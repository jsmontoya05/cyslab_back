<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class VirtualNetworkService
{
    use ConsumesExternalService;

    /**
     * The base uri to consume the books service
     * @var string
     */
    public $baseUri;

    /**
     * The secret to consume the authors service
     * @var string
     */
    public $secret;

    public function __construct()
    {
        $this->baseUri = 'https://management.azure.com';
        $this->secret = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsIng1dCI6Im5PbzNaRHJPRFhFSzFqS1doWHNsSFJfS1hFZyIsImtpZCI6Im5PbzNaRHJPRFhFSzFqS1doWHNsSFJfS1hFZyJ9.eyJhdWQiOiJodHRwczovL21hbmFnZW1lbnQuYXp1cmUuY29tLyIsImlzcyI6Imh0dHBzOi8vc3RzLndpbmRvd3MubmV0L2Y1ZDU2ZTkxLTBmYmMtNGUxOC1iZTFkLTBiZWYxNzM4NWZmMy8iLCJpYXQiOjE2MTU5NTUwOTcsIm5iZiI6MTYxNTk1NTA5NywiZXhwIjoxNjE1OTU4OTk3LCJhaW8iOiJFMlpnWURqT0h5SEtidkxuYlUzcXZVY3lPUyszQUFBPSIsImFwcGlkIjoiYTQ1OGVlM2QtZDk1OC00NzFkLWI4NzQtNjg5MzM5OWU0MmZiIiwiYXBwaWRhY3IiOiIxIiwiaWRwIjoiaHR0cHM6Ly9zdHMud2luZG93cy5uZXQvZjVkNTZlOTEtMGZiYy00ZTE4LWJlMWQtMGJlZjE3Mzg1ZmYzLyIsIm9pZCI6IjNiNjM1MWQwLTJhMTItNDIxNS1iMDA4LThkMGQ3NDBjODQ1YiIsInJoIjoiMC5BQUFBa1c3Vjlid1BHRTYtSFF2dkZ6aGY4ejN1V0tSWTJSMUh1SFJva3ptZVF2dDhBQUEuIiwic3ViIjoiM2I2MzUxZDAtMmExMi00MjE1LWIwMDgtOGQwZDc0MGM4NDViIiwidGlkIjoiZjVkNTZlOTEtMGZiYy00ZTE4LWJlMWQtMGJlZjE3Mzg1ZmYzIiwidXRpIjoiWGZ3eHBZWGRGMEN4dGx1bWJxR0xBQSIsInZlciI6IjEuMCIsInhtc190Y2R0IjoxNjE1MzQxNTQ1fQ.EI8iLoxZxbK-8A-ZvnYlq9O4xwazsXHXkTBHkGwq6wSIuUBQjl_0XQ_1loFFuVy0Khcrv2XdM-v7Zca5f-vYAso89VDS8bLvPWKIPuJ6baPyEHpb5Q-nuJ9Q1VXp7nbb4dWlzTmMQ9gZHNlnI6w9pqZYNVXtRii0JjFsaKjJtzF7jhNTV9RFUY1jRPxKahlXr5IQvB4PKlMvdb5PlnyG_Rx52HbAFs45UvY1-reYQDBdk22exKoxRYTm_23yack3vFA8K22ZFyDIi9kndVWI_RjDvwaJK9XQsa_22JO2MFLoupjTSOTO8Cpg2JP7sp1B34R06PP7xte327kKzXNzCA';
        /* $this->secret = $this->getTokenBearer('/books'); */
    }

    /**
     * Obtain the full list of book from the book service
     * @return string
     */
    public function obtainVirtualNetwork()
    {
        return $this->formatResponse($this->performRequest('GET', '/subscriptions/9e48a3a1-861c-4c46-b7ff-6e5486017825/resourceGroups/vim_group/providers/Microsoft.DevTestLab/labs/lab1/virtualnetworks?api-version=2018-09-15'));
    }

    /**
     * Create one book using the book service
     * @return string
     */
    public function createBook($data)
    {
        return $this->performRequest('POST', '/books', $data);
    }

    /**
     * Obtain one single book from the book service
     * @return string
     */
    public function obtainBook($book)
    {
        return $this->performRequest('GET', "/books/{$book}");
    }

    /**
     * Update an instance of book using the book service
     * @return string
     */
    public function editBook($data, $book)
    {
        return $this->performRequest('PUT', "/books/{$book}", $data);
    }

    /**
     * Remove a single book using the book service
     * @return string
     */
    public function deleteBook($book)
    {
        return $this->performRequest('DELETE', "/books/{$book}");
    }

    private function formatResponse($response){
        return json_decode($response ,true)["value"];
    }
}
