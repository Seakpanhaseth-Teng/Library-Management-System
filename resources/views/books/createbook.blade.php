<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a New Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Adjust alignment to prevent overflow */
            min-height: 100vh;
            box-sizing: border-box;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 90%; /* Adjust width to fit smaller screens */
            max-width: 400px; /* Ensure it doesn't exceed a reasonable size */
            margin: 20px auto; /* Add margin for spacing */
            box-sizing: border-box;
        }
        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333; /* Ensure the label text is visible */
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            color: #333; /* Ensure input text is visible */
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Add a New Book</h1>
        <form action="{{ url('books/add') }}" method="POST">
            @csrf

            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="author">Author:</label>
            <input type="text" id="author" name="author" required>

            <label for="isbn">ISBN:</label>
            <input type="text" id="isbn" name="isbn" required>

            <label for="publisher">Publisher:</label>
            <input type="text" id="publisher" name="publisher" required>

            <label for="publication_year">Published Year:</label>
            <input type="number" id="publication_year" name="publication_year" required>

            <label for="genre">Genre:</label>
            <input type="text" id="genre" name="genre" required>

            <label for="pages">Pages:</label>
            <input type="number" id="pages" name="pages" required>

            <label for="shelf_location">Shelf Location:</label>
            <input type="text" id="shelf_location" name="shelf_location" required>

            <label for="available_copies">Available Copies:</label>
            <input type="number" id="available_copies" name="available_copies" required>

            <label for="is_available">Is Available:</label>
            <input type="text" id="is_available" name="is_available" required>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>