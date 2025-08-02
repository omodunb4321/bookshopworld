-- BookStore Database
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS cart_items;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

-- users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- categories table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    author VARCHAR(200) NOT NULL,
    category_id INT,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    paperback BOOLEAN DEFAULT TRUE,
    hardcover BOOLEAN DEFAULT FALSE,
    ebook BOOLEAN DEFAULT FALSE,
    image_url VARCHAR(255),
    is_featured BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- cart table
CREATE TABLE cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT DEFAULT 1,
    format VARCHAR(20) DEFAULT 'paperback',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- orders table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- categories 
INSERT INTO categories (name) VALUES
('Fiction'),
('Mystery'),
('Romance'),
('Science Fiction'),
('History'),
('Biography'),
('Self-Help'),
('Technology'),
('Business'),
('Art');

-- books
INSERT INTO products (title, author, category_id, description, price, paperback, hardcover, ebook, is_featured) VALUES
('The Great Adventure', 'John Smith', 1, 'An exciting adventure story about courage and friendship.', 19.99, TRUE, TRUE, TRUE, TRUE),
('Mystery Manor', 'Jane Doe', 2, 'A thrilling mystery set in an old mansion.', 16.99, TRUE, FALSE, TRUE, FALSE),
('Love in Spring', 'Emily Rose', 3, 'A romantic story about finding love in unexpected places.', 14.99, TRUE, TRUE, FALSE, TRUE),
('Space Journey', 'Mike Chen', 4, 'Travel to distant galaxies in this sci-fi adventure.', 22.99, TRUE, TRUE, TRUE, FALSE),
('Ancient Rome', 'Dr. Williams', 5, 'Discover the secrets of the Roman Empire.', 24.99, FALSE, TRUE, TRUE, TRUE),
('Life of Success', 'Tony Winner', 6, 'The inspiring story of a business leader.', 18.99, TRUE, TRUE, FALSE, FALSE),
('Be Your Best', 'Sara Helpful', 7, 'Tips for personal growth and happiness.', 15.99, TRUE, FALSE, TRUE, TRUE),
('Learn to Code', 'Tech Guru', 8, 'A beginner\'s guide to programming.', 29.99, TRUE, TRUE, TRUE, FALSE),
('Start a Business', 'Rich Success', 9, 'How to build a successful company.', 21.99, TRUE, TRUE, TRUE, TRUE),
('Drawing Basics', 'Artist Pro', 10, 'Learn to draw like a professional.', 17.99, TRUE, FALSE, TRUE, FALSE),
('Detective Stories', 'Mystery Writer', 2, 'Collection of exciting detective tales.', 19.99, TRUE, TRUE, FALSE, FALSE),
('Future World', 'Sci Fi Fan', 4, 'What will the world look like in 2100?', 20.99, TRUE, FALSE, TRUE, TRUE),
('War Heroes', 'History Buff', 5, 'Stories of brave soldiers throughout history.', 23.99, FALSE, TRUE, TRUE, FALSE),
('Happy Life', 'Joy Seeker', 7, 'Simple ways to find happiness every day.', 13.99, TRUE, TRUE, FALSE, FALSE),
('Web Design', 'Code Master', 8, 'Create beautiful websites step by step.', 31.99, TRUE, TRUE, TRUE, TRUE),
('Money Matters', 'Finance Pro', 9, 'Smart ways to manage your money.', 25.99, TRUE, TRUE, TRUE, FALSE),
('Love Letters', 'Romance Queen', 3, 'Beautiful love stories from around the world.', 16.99, TRUE, FALSE, TRUE, FALSE),
('Magic Kingdom', 'Fantasy Writer', 1, 'A magical adventure in a faraway land.', 18.99, TRUE, TRUE, FALSE, TRUE),
('Solve the Case', 'Detective Dan', 2, 'Can you solve these puzzling mysteries?', 17.99, TRUE, FALSE, TRUE, FALSE),
('Space Wars', 'Battle Writer', 4, 'Epic battles among the stars.', 21.99, TRUE, TRUE, TRUE, FALSE),
('Famous People', 'Bio Expert', 6, 'Stories of people who changed the world.', 19.99, FALSE, TRUE, TRUE, TRUE),
('Art History', 'Culture Fan', 10, 'Beautiful art from ancient times to today.', 26.99, TRUE, TRUE, TRUE, FALSE);

-- Add admin user (password: admin123)
INSERT INTO users (username, email, password, first_name, last_name, is_admin) VALUES
('admin', 'admin@bookstore.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'User', TRUE);

-- Add test user (password: test123)
INSERT INTO users (username, email, password, first_name, last_name) VALUES
('testuser', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Test', 'User');