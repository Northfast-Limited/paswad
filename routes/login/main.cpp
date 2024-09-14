#include "src/libs/crow_all.h"
#include "src/libs/json.hpp"
#include <iostream>
#include "src/wsDbConfig/wsDbConfig.h"

// Function to verify user credentials from the database
// (Consider moving this to a different class later)
bool verify_credentials(wsDbConfig& dbConfig, const std::string& username, const std::string& password) {
    try {
        pqxx::work W(*dbConfig.getConnection());
        std::string query = "SELECT * FROM fgg WHERE username = " + W.quote(username) + " AND password = " + W.quote(password) + ";";
        pqxx::result R = W.exec(query);
        return !R.empty();
    } catch (const std::exception &e) {
        std::cerr << "Database error: " << e.what() << std::endl;
        return false;
    }
}

// Function to create a JSON response with pretty-printing
nlohmann::json create_response(const std::string& message, int status) {
    nlohmann::json response_json;
    response_json["message"] = message;
    response_json["status"] = status;
    return response_json;
}

// Main function
int main() {
    crow::SimpleApp app;
    wsDbConfig dbConfig("samplex", "msl", "BK221409", "127.0.0.1", 5432);

    // Route for authentication
    CROW_ROUTE(app, "/login").methods("POST"_method, "GET"_method)([&dbConfig](const crow::request& req) {
        if (req.method == crow::HTTPMethod::Post) {
            auto json_data = nlohmann::json::parse(req.body);
            std::string username = json_data["username"];
            std::string password = json_data["password"];

            // Verify credentials using the database
            nlohmann::json response_json;
            if (verify_credentials(dbConfig, username, password)) {
                response_json = create_response("Login successful!", 200);
                // Pretty-print the JSON response with an indentation of 4 spaces
                return crow::response(200, response_json.dump(4), "application/json");
            } else {
                response_json = create_response("Invalid credentials", 401);
                // Pretty-print the JSON response with an indentation of 4 spaces
                return crow::response(401, response_json.dump(4), "application/json");
            }
        } else {
            nlohmann::json response_json = create_response("Method Not Allowed", 405);
            // Pretty-print the JSON response with an indentation of 4 spaces
            return crow::response(405, response_json.dump(4), "application/json");
        }
    });

    app.port(18083).multithreaded().run();
    return 0;
}
