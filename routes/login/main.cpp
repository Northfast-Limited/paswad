#include "crow_all.h"
#include "json.hpp"
#include <iostream>

// Define a struct for user credentials
struct User {
    std::string username;
    std::string password;
};

// Simulated database for user credentials as an array of structs
User user_db[] = {
    {"user1", "password123"},
    {"user2", "password456"}
};

// Function to verify user credentials
bool verify_credentials(const std::string& username, const std::string& password) {
    for (const auto& user : user_db) {
        if (user.username == username && user.password == password) {
            return true;
        }
    }
    return false;
}

int main() {
    crow::SimpleApp app;

    // Route for authentication
    CROW_ROUTE(app, "/login").methods("POST"_method)([](const crow::request& req) {
        auto json_data = nlohmann::json::parse(req.body);

        std::string username = json_data["username"];
        std::string password = json_data["password"];

        // Verify credentials
        if (verify_credentials(username, password)) {
            nlohmann::json response_json;
            response_json["message"] = "Login successful!";
            response_json["status"] = 200;
            return crow::response(200, response_json.dump());
        } else {
            nlohmann::json response_json;
            response_json["message"] = "Invalid credentials";
            response_json["status"] = 401;
            return crow::response(401, response_json.dump());
        }
    });

    app.port(18080).multithreaded().run();
    return 0;
}
