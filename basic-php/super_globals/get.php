<?php
    // Initialize variables
    $search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
    $category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '';
    $sort = isset($_GET['sort']) ? htmlspecialchars($_GET['sort']) : 'title';

    // Sample book data (in a real application, this would come from a database)
    $books = [
        ['title' => 'PHP & MySQL Novice to Ninja', 'category' => 'Programming', 'year' => 2021],
        ['title' => 'Learning PHP, MySQL & JavaScript', 'category' => 'Programming', 'year' => 2020],
        ['title' => 'Modern PHP', 'category' => 'Programming', 'year' => 2019],
        ['title' => 'Clean Code', 'category' => 'Software Design', 'year' => 2008],
        ['title' => 'Design Patterns', 'category' => 'Software Design', 'year' => 1994],
    ];

    // Filter books based on search and category
    $filtered_books = array_filter($books, function($book) use ($search, $category) {
        $match_search = empty($search) || stripos($book['title'], $search) !== false;
        $match_category = empty($category) || $book['category'] === $category;
        return $match_search && $match_category;
    });

    // Sort books
    if ($sort === 'year') {
        usort($filtered_books, function($a, $b) {
            return $b['year'] - $a['year'];
        });
    } else { // sort by title
        usort($filtered_books, function($a, $b) {
            return strcmp($a['title'], $b['title']);
        });
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Search</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .search-form {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .book-list {
            list-style: none;
            padding: 0;
        }
        .book-item {
            background: #fff;
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .filters {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>Book Search</h1>
    
    <div class="search-form">
        <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="filters">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search books..."
                    value="<?php echo $search; ?>"
                >
                
                <select name="category">
                    <option value="">All Categories</option>
                    <option value="Programming" <?php echo $category === 'Programming' ? 'selected' : ''; ?>>
                        Programming
                    </option>
                    <option value="Software Design" <?php echo $category === 'Software Design' ? 'selected' : ''; ?>>
                        Software Design
                    </option>
                </select>
                
                <select name="sort">
                    <option value="title" <?php echo $sort === 'title' ? 'selected' : ''; ?>>
                        Sort by Title
                    </option>
                    <option value="year" <?php echo $sort === 'year' ? 'selected' : ''; ?>>
                        Sort by Year
                    </option>
                </select>
                
                <button type="submit">Search</button>
            </div>
        </form>
    </div>

    <?php if (count($filtered_books) > 0): ?>
        <ul class="book-list">
            <?php foreach ($filtered_books as $book): ?>
                <li class="book-item">
                    <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                    <p>Category: <?php echo htmlspecialchars($book['category']); ?></p>
                    <p>Year: <?php echo htmlspecialchars($book['year']); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No books found matching your criteria.</p>
    <?php endif; ?>
</body>
</html>