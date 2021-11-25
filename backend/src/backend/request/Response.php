<?php

require_once __DIR__ . '/../util/constant/ContentType.php';
require_once __DIR__ . '/../util/constant/ErrorStrings.php';
require_once __DIR__ . '/../util/constant/StatusCode.php';
require_once __DIR__ . '/../util/constant/CORS.php';
require_once __DIR__ . '/../util/Map.php';

/**
 * Utility object for sending responses to the client
 * This can be freely constructed wherever needed however the Connection
 * always holds an instance (Connection::$res)
 *
 * @see Session
 */
class Response {
    /**
     * Sends JSON to the client
     *
     * This function will end the program exit code 0, stopping execution
     *
     * @param Map|string $data a Map, or string, representing the JSON to send in the response
     * @param string[] $headers the headers to include in the response
     *
     * @return void This function never returns
     */
    public function sendJSON($data, ...$headers) {
        if (is_map($data)) {
            $this -> send(json_encode($data), CORS::ALL, ContentType::JSON, ...$headers);
        }
        else if (is_string($data)) {
            $this -> send(json_encode(json_decode($data)), CORS::ALL, ContentType::JSON, ...$headers); // encode/decode for validation
        }
        else if (is_array($data)) {
            throw new UnexpectedValueException("Got array passed to sendJSON, did you forget to call map()?");
        }
        else {
            throw new UnexpectedValueException("Expected JSON-like data");
        }
        die(0);
    }

    /**
     * Sends arbitrary data to the client.
     * This method performs NO validation on the input, use it with caution.
     *
     * This function will end the program exit code 0, stopping execution
     *
     * @param mixed $data the data to send in the response
     * @param string[] $headers the headers to send in the response
     *
     * @return void This function never returns
     */
    public function send($data, ...$headers) {
        foreach ($headers as $header) {
            header($header);
        }

        echo $data;
        die(0);
    }

    /**
     * Sends an error message to the client
     *
     * This function will kill the program, stopping execution
     *
     * @param string $message the message to send in the response, must be JSON serializable
     * @param string[] $headers the headers to send in the response
     *
     * @return void This function never returns
     */
    public function sendError($message, ...$headers) {
        //TODO log exceptions to stderr when we get them
        $this -> send(json_encode([
            "error" => true,
            "message" => $message
        ]), ContentType::JSON, CORS::ALL, ...$headers);
        die(0);
    }

    /**
     * Sends a generic internal error response
     *
     * This function will kill the program, stopping execution
     *
     * @return void This function never returns
     */
    public function sendInternalError() {
        //TODO log exceptions to stderr when we get them
        $this -> sendError(ErrorStrings::INTERNAL_ERROR, StatusCode::INTERNAL_ERROR);
        die(1);
    }
}
