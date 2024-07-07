<?php

namespace App\Http\Traits;

trait ApiResponseTrait
{
    /**
     * Generate API response.
     *
     * @param  mixed  $data The response data.
     * @param  string  $token The access token.
     * @param  string  $message The response message.
     * @param  int  $status The HTTP status code.
     * @return \Illuminate\Http\JsonResponse The API response.
     */
    public function apiResponse(mixed $data, string $token, string $message, int $status)
    {

        $array = [
            'data' => $data,
            'message' => $message,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];

        return response()->json($array, $status);
    }

    /**
     * Generate custom API response.
     *
     * This method generates a JSON response for API requests. It supports paginated data
     * and includes pagination details if the provided data is an instance of
     * \Illuminate\Pagination\LengthAwarePaginator.
     *
     * @param  mixed  $data    The response data. It can be any data type, including paginated data.
     * @param  string $message A message describing the response.
     * @param  int    $status  The HTTP status code for the response.
     * @return \Illuminate\Http\JsonResponse The API response in JSON format.
     */
    public function customeResponse(mixed $data, string $message, int $status)
    {
        $array = [
            'data' => $data,
            'message' => $message
        ];

        if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $array['pagination'] = [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage()
            ];
        }

        return response()->json($array, $status);
    }
}
