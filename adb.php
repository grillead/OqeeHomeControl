<?php

class adb
{

    public $success;
    public $error_msg;
    public $host;
    public $port;
    public $uri;
    public $log;
    public $isDeviceConnected;
    public $isUnauthorized;
    public $isError;
    public $isUnable;
    public $isDisplayOn;
    public $logFile;

    function __construct()
    {
        $this->logFile = '/var/log/adb.txt';
        $this->isDeviceConnected = false;
        $this->isUnauthorized = false;
        $this->isUnable = false;
        $this->isError = false;
        $this->isDisplayOn = false;
        $this->success = false;
        $this->error_msg = "";
    }

    private function elog($msg)
    {
        if (!empty(trim($msg))) {
            file_put_contents($this->logFile, $msg . PHP_EOL, FILE_APPEND | LOCK_EX);
        }
    }

    private function myShellExec($cmd)
    {
        ob_start();
        $lastLine = (string)system($cmd . " 2>&1", $returnVal);
        $strOutput = (string)ob_get_contents();
        ob_end_clean();

        $value = $returnVal ? $lastLine : $strOutput;
        if (!empty(trim($value))) {
            file_put_contents($this->logFile, $value . PHP_EOL, FILE_APPEND | LOCK_EX);
        }

        return $value;
    }

    private function getDeviceConnectionStatus()
    {
        $results = $this->myShellExec("adb devices | grep $this->uri;");
        return $results ? $this->checkResponse($results) : false;
    }

    private function getDisplayPowerStatus()
    {
        $results =  $this->myShellExec("adb -s $this->uri shell dumpsys power | grep 'Display Power: state=ON';");
        return $results ? $this->checkResponse($results) : false;
    }

    private function checkResponse($results)
    {
        if (strpos($results, 'unauthorized') !== false) {
            $this->elog("Connection is unauthorized to $this->uri");
            $this->isUnauthorized = true;
            return false;
        }

        if (strpos($results, 'unable') !== false) {
            $this->elog("Failed to connect to $this->uri");
            $this->isUnable = true;
            return false;
        }

        if (strpos($results, 'error') !== false) {
            $this->elog("General error with device $this->uri");
            $this->isError = true;
            return false;
        }

        return true;
    }

    public function connectToDevice()
    {
        $results = $this->getDeviceConnectionStatus();
        if ($results) {
            $this->elog("Device is already connected to $this->uri");
            return true;
        } else {

            if($this->isUnauthorized || $this->isUnable || $this->isError){
                $this->myShellExec("adb disconnect $this->uri;");
                return false;
            }

            $this->elog("Connecting to $this->uri");
            $results = $this->myShellExec("adb connect $this->uri;");
            return $this->checkResponse($results);
        }

    }

    public function setDevice($device = [])
    {
        $this->host = $device['host'];
        $this->port = isset($device['port']) ? $device['port'] : 5555;
        $this->uri = "$this->host:$this->port";

        if (!`which adb`) {
            $this->success = false;
            $this->error_msg = "ADB doesn't exist.";
        }else{
            $this->success = true;
        }

        return ['success' => $this->success, 'error_msg' => $this->error_msg];
    }

    public function turnOff()
    {
        $this->elog("Turning off Display on $this->uri");
        $this->isDeviceConnected = $this->connectToDevice();
        if ($this->isDeviceConnected) {
            $this->isDisplayOn = $this->getDisplayPowerStatus();
            if ($this->isDisplayOn) {
                $this->sendKey("KEYCODE_POWER");
                $this->isDisplayOn = $this->getDisplayPowerStatus();

                if ($this->isDisplayOn) {
                    $this->sendKey("KEYCODE_SLEEP");
                    $this->isDisplayOn = $this->getDisplayPowerStatus();
                }
            }
        }

        // Response
        if ($this->isDeviceConnected && !$this->isDisplayOn) {
            $this->success = true;
        } elseif ($this->isDeviceConnected && $this->isDisplayOn) {
            $this->success = true;
            $this->error_msg = "Device is connected but could not turn off Display";
        } elseif (!$this->isDeviceConnected) {
            $this->success = false;
            $this->error_msg = "Could not connect to device";
        }

        return ['success' => $this->success, 'connected' => $this->isDeviceConnected, 'display' => $this->isDisplayOn, 'error_msg' => $this->error_msg];
    }

    public function turnOnAndConnect()
    {
        $this->elog("Turning on Display on $this->uri");
        $this->isDeviceConnected = $this->connectToDevice();
        if ($this->isDeviceConnected) {
            $this->isDisplayOn = $this->getDisplayPowerStatus();
            if (!$this->isDisplayOn) {
                $this->sendKey("KEYCODE_WAKEUP");
                $this->isDisplayOn = $this->getDisplayPowerStatus();

                if(!$this->isDisplayOn){
                    $this->sendKey("KEYCODE_POWER");
                    $this->isDisplayOn = $this->getDisplayPowerStatus();
                }
            }
        }

        // Response
        if ($this->isDeviceConnected && $this->isDisplayOn) {
            $this->success = true;
        } elseif ($this->isDeviceConnected && !$this->isDisplayOn) {
            $this->success = true;
            $this->error_msg = "Device is connected but could not turn on Display";
        } elseif (!$this->isDeviceConnected) {
            $this->success = false;
            $this->error_msg = "Could not connect to device";
        }

        return ['success' => $this->success, 'connected' => $this->isDeviceConnected, 'display' => $this->isDisplayOn, 'error_msg' => $this->error_msg];
    }

    public function turnOnAndConnectAndLaunch($package)
    {
        $this->elog("Turning on $package on $this->uri");
        $connected = $this->turnOnAndConnect();
        if ($connected['success']) {
            $this->sendKey("KEYCODE_WAKEUP");
            $packageIntent = $this->myShellExec('adb -s ' . $this->uri . ' shell pm dump ' . $package . ' | grep -A 1 "MAIN" | grep ' . $package . ' | awk \'{print $2}\' | grep ' . $package . ';');
            $results = $this->myShellExec('adb -s ' . $this->uri . ' shell am start -n ' . $packageIntent);
            if (!$this->checkResponse($results)) {
                $connected['success'] = false;
                $connected['error_msg'] = $results;
            }
        }

        return $connected;
    }

    public function turnOnAndConnectAndLaunchNetflixWithVideoId($id = null)
    {
        $this->elog("Turning on Netflix with Video ID: $id on $this->uri");
        $connected = $this->turnOnAndConnect();
        if (!empty($id)) {
            if ($connected['success']) {
                $this->sendKey("KEYCODE_WAKEUP");
                $results = $this->myShellExec('adb -s ' . $this->uri . ' shell "am start -W -a android.intent.action.VIEW -d http://www.netflix.com/watch/' . $id . ' -e source 30 com.netflix.ninja/com.netflix.ninja.MainActivity";');
                if (!$this->checkResponse($results)) {
                    $connected['success'] = false;
                    $connected['error_msg'] = $results;
                }
            }
        }

        return $connected;
    }

    public function sendKey($keys)
    {
        $this->elog("Sending keys $keys on $this->uri");
        $results = $this->myShellExec("adb -s $this->uri shell input keyevent $keys;");
        return $this->checkResponse($results);
    }

}
