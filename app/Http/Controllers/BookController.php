<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use Domain\Book\Exceptions\BookISNBAlreadyExistException;
use Domain\Book\UseCases\CreateBook\CreateBook;
use Domain\Book\UseCases\CreateBook\DTO;
use Domain\Book\UseCases\DeleteBook\DeleteBook;
use Domain\Book\UseCases\GetBooks\GetBooks;
use Domain\Book\UseCases\UpdateBook\UpdateBook;
use Exception;
use Infra\Book\Repositories\BookRepository;
use Domain\Book\Exceptions\NotFoundBookException;
use Domain\Book\UseCases\GetBook\GetBook;
use Domain\Book\UseCases\UpdateBook\DTO as UpdateBookDTO;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    public function index(): JsonResponse
    {
        $getBooks = new GetBooks(new BookRepository());

        try {
            $books = $getBooks->execute();
        } catch (Exception $e) {    
            return response()->json(['message' => 'Server Error'], 500);
        }

        return response()->json(["data" => $books]);
    }

    public function store(BookRequest $request): JsonResponse
    {
        $DTO = new DTO(
            $request->name,
            $request->isbn,
            $request->value,
        );

        $createBook = new CreateBook(new BookRepository());

        try {
           $book = $createBook->execute($DTO);
        } catch (BookISNBAlreadyExistException) {
            return response()->json(['messsage' => 'ISNB already exist'], 422);
        } catch (Exception) {
            return response()->json(['message' => 'Server Error'], 500);
        }

        return response()->json(['data' => $book]);
    }

    public function update(int $bookId, BookRequest $request): JsonResponse
    {
        $DTO = new UpdateBookDTO(
            $bookId,
            $request->name,
            $request->isbn,
            $request->value,
        );

        $updateBook = new UpdateBook(new BookRepository());

        try {
           $book = $updateBook->execute($DTO);
        } catch (NotFoundBookException) {
            return response()->json([], 404);
        } catch (BookISNBAlreadyExistException) {
            return response()->json(['messsage' => 'ISNB already exist'], 422);
        } catch (Exception) {
            return response()->json(['message' => 'Server Error'], 500);
        }

        return response()->json(['data' => $book]);
    }

    public function show(int $bookId): JsonResponse
    {
        $getBook = new GetBook(new BookRepository());

        try {
            $book = $getBook->execute($bookId);
        } catch (NotFoundBookException) {
            return response()->json([], 404);
        } catch (Exception) {
            return response()->json(['message' => 'Server Error'], 500);
        }

        return response()->json(['data' => $book]);
    }

    public function destroy(int $bookId): JsonResponse
    {
        $deleteBook = new DeleteBook(new BookRepository());

        try {
            $deleteBook->execute($bookId);
        } catch (NotFoundBookException) {
            return response()->json([], 404);
        } catch (Exception) {
            return response()->json(['message' => 'Server Error'], 500);
        }

        return  response()->json([], 204);
    }
}
