<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class OpenLibraryService
{
    const COVER_URL = 'https://covers.openlibrary.org/b/isbn/%s-L.jpg';
    const API_URL = 'https://openlibrary.org/api/books?bibkeys=ISBN:%s&format=json&jscmd=data';

    public function fetchCoverByIsbn(string $isbn): ?string
    {
        $filename = 'covers/' . $isbn . '.jpg';

        if (Storage::disk('public')->exists($filename)) {
            return $filename;
        }

        try {
            $coverUrl = sprintf(self::COVER_URL, $isbn);
            $response = Http::timeout(5)->get($coverUrl);

            if ($response->successful() && strlen($response->body()) > 1000) {
                Storage::disk('public')->put($filename, $response->body());
                return $filename;
            }
        } catch (RequestException | ConnectionException) {
            // Silently fail — cover is not critical
        }

        return null;
    }

    public function getBookInfo(string $isbn): ?array
    {
        try {
            $url = sprintf(self::API_URL, $isbn);
            $response = Http::timeout(5)->get($url);

            if ($response->successful()) {
                $data = $response->json();
                $key = 'ISBN:' . $isbn;

                if (isset($data[$key])) {
                    return $data[$key];
                }
            }
        } catch (RequestException | ConnectionException) {
            // Silently fail
        }

        return null;
    }
}
