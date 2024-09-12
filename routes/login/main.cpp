#include "crow_all.h"
#include "json.hpp"
#include <iostream>
#include "src/wsDbConfig/wsDbConfig.h"

// Function to verify user credentials from the database
bool verify_credentials(wsDbConfig& dbConfig, const std::string& username, const std::string& password) {
    try {
        pqxx::work W(*dbConfig.getConnection());
        std::string query = "SELECT * FROM fgg WHERE username = " + W.quote(username) + " AND password = " + W.quote(password) + ";";
        pqxx::result R = W.exec(query);

        if (!R.empty()) {
            return true;
        }
        return false;
    } catch (const std::exception &e) {
        std::cerr << "Database error: " << e.what() << std::endl;
        return false;
    }
}

int main() {
    crow::SimpleApp app;

    // Initialize database configuration
    wsDbConfig dbConfig("samplex", "msl", "BK221409", "127.0.0.1", 5432);

    // Route for authentication
    CROW_ROUTE(app, "/login").methods("POST"_method)([&dbConfig](const crow::request& req) {
        auto json_data = nlohmann::json::parse(req.body);

        std::string username = json_data["username"];
        std::string password = json_data["password"];

        // Verify credentials using the database
        if (verify_credentials(dbConfig, username, password)) {
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

    app.port(18083).multithreaded().run();
    return 0;
}
