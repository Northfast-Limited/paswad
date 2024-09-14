// login_manager.hpp
#ifndef LOGIN_MANAGER_HPP
#define LOGIN_MANAGER_HPP

#include <iostream>
#include <string>
#include <vector>
#include <openssl/sha.h>  // For password hashing

class wsLogin {
public:
    // Structure for user info
    struct User {
        std::string username;
        std::string hashedPassword;
        std::string role;
    };

    // Constructor
    wsLogin(const std::string& secretKey);

    // Register a new user
    bool registerUser(const std::string& username, const std::string& password, const std::string& role = "user");

    // Login user and return a simple token if successful
    std::string login(const std::string& username, const std::string& password);

    // Validate token (dummy validation for simplicity)
    bool validateToken(const std::string& token);

    // Hash a password using SHA-256
    static std::string hashPassword(const std::string& password);

private:
    std::vector<User> users;  // Simple vector to store users
    std::string jwtSecretKey;  // Secret key for token generation

    // Generate a simple token for a user
    std::string generateToken(const User& user);

    // Find user by username
    User* findUserByUsername(const std::string& username);
};

#endif // LOGIN_MANAGER_HPP
