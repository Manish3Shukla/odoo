-- Users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    points INT DEFAULT 0,
    role ENUM('user', 'admin') DEFAULT 'user'
);

-- Items
CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(150),
    description TEXT,
    category VARCHAR(100),
    size VARCHAR(10),
    condition VARCHAR(50),
    tags VARCHAR(255),
    status ENUM('available', 'swapped', 'pending') DEFAULT 'available',
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id)
);

-- Swaps
CREATE TABLE swaps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT,
    requester_id INT,
    method ENUM('swap', 'points'),
    status ENUM('pending', 'accepted', 'rejected', 'completed'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(item_id) REFERENCES items(id),
    FOREIGN KEY(requester_id) REFERENCES users(id)
);

--item

CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(150),
    description TEXT,
    category VARCHAR(100),
    size VARCHAR(10),
    condition VARCHAR(50),
    tags VARCHAR(255),
    image_path VARCHAR(255),
    status ENUM('available', 'swapped', 'pending') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id)
);
--
-- Swaps
CREATE TABLE swaps (
  id INT AUTO_INCREMENT PRIMARY KEY,
  requester_id INT,
  item_id INT,
  method ENUM('swap', 'points'),
  status ENUM('pending', 'approved', 'declined') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY(requester_id) REFERENCES users(id),
  FOREIGN KEY(item_id) REFERENCES items(id)
);


