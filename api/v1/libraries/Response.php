<?php

class Response
{
    private $httpStatusCode;
    private $success;
    private $toCache = false;
    private $message = array();
    private $data;
    private $responseData = array();


    public function setHttpStatusCode($statusCode)
    {
        $this->httpStatusCode = $statusCode;
    }

    public function setSuccess($success)
    {
        $this->success = $success;
    }

    public function toCache($toCache)
    {
        $this->toCache = $toCache;
    }

    public function addMessage($message)
    {
        $this->message[] = $message;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function send()
    {
        // set response header contact type to json utf-8
		header('Content-type:application/json;charset=utf-8');
		
		// if response is cacheable then add http cache-control header with a timeout of 60 seconds
		// else set no cache
		if($this->toCache == true) {
			header('Cache-Control: max-age=60');
		}
		else {
			header('Cache-Control: no-cache, no-store');
		}

        // if (!is_numeric($this->httpStatusCode) && !$this->success) {
        //     http_response_code(500);
        //     $this->responseData['statusCode'] = 500;
        //     $this->responseData['success'] = false;
        //     $this->responseData['message'] = "Error creating response";
        // } else {
        //     $this->responseData['statusCode'] = $this->httpStatusCode;
        //     $this->responseData['success'] = $this->success;
        //     $this->responseData['message'] = $this->message;
        //     $this->responseData['data'] = $this->data;
        // }
        // echo json_encode($this->responseData);

        if(!is_numeric($this->httpStatusCode) || ($this->success !== false && $this->success !== true )) {
			// set http status code in response header
			http_response_code(500);
			// set statusCode in json response
			$this->responseData['statusCode'] = 500;
			// set success flag in json response
			$this->responseData['success'] = false;
			// set custom error message
			$this->addMessage("Response creation error");
			// set messages in json response
			$this->responseData['messages'] = $this->messages;
		}
		else {
			// set http status code in response header
			http_response_code($this->httpStatusCode);
			// set statusCode in json response
			$this->responseData['statusCode'] = $this->httpStatusCode;
			// set success flag in json response
			$this->responseData['success'] = $this->success;
			// set messages in json response
			$this->responseData['message'] = $this->message;
			// set data array in json response
			$this->responseData['data'] = $this->data;
		}

		// encode the responseData array to json response output
		echo json_encode($this->responseData);
    }
}
