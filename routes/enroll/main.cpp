#include "src/libs/crow_all.h"
#include "src/libs/json.hpp"
#include <iostream>
#include "src/wsDbConfig/wsDbConfig.h"

// Function to verify user credentials from the database
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

// Function to create a JSON response with a specific structure
nlohmann::json create_response(int responseCode, const std::string& message, int affectedRows, long long timestamp, const std::string& content) {
    nlohmann::json response_json;
    response_json["response"]["responseCode"] = responseCode;
    response_json["response"]["payload"]["message"] = message;
    response_json["response"]["payload"]["affectedRows"] = affectedRows;
    response_json["response"]["payload"]["Responsetimestamp"] = timestamp;
    response_json["response"]["payload"]["content"] = content;
    return response_json;
}

// Main function
int main() {
    crow::SimpleApp app;
    wsDbConfig dbConfig("samplex", "msl", "BK221409", "127.0.0.1", 5432);

    // Route for authentication
    CROW_ROUTE(app, "/login").methods("POST"_method, "GET"_method)([&dbConfig](const crow::request& req) {
        if (req.method == crow::HTTPMethod::Post) {
            try {
                auto json_data = nlohmann::json::parse(req.body);
                std::string username = json_data["username"];
                std::string password = json_data["password"];

                int responseCode;
                std::string message;
                int affectedRows = 1; // Example value
                long long timestamp = 1714952869; // Example timestamp
                std::string content;

                if (verify_credentials(dbConfig, username, password)) {
                    responseCode = 1;
                    message = "found";
                    //call class to generate dashboard jwt and give api response
                    content = "<input data-timestamp='" + std::to_string(timestamp) + "' type='password' required placeholder='password' id='password'><button onclick='pwdCheckApi()'type='button' identifiertoken='" + std::to_string(timestamp) + "'>Continue</button>";
                } else {
                    responseCode = 0;
                    message = "not found";
                    content = ""; // Empty content
                }

                nlohmann::json response_json = create_response(responseCode, message, affectedRows, timestamp, content);
                // Create a Crow response with JSON content type
                crow::response res(200, response_json.dump(4));
                res.set_header("Content-Type", "application/json");
                return res;
            } catch (const std::exception &e) {
                nlohmann::json response_json = create_response(0, "Invalid JSON format", 0, 0, "");
                // Create a Crow response with JSON content type
                crow::response res(400, response_json.dump(4));
                res.set_header("Content-Type", "application/json");
                return res;
            }
        } else {
            nlohmann::json response_json = create_response(0, "Method Not Allowed", 0, 0, "");
            // Create a Crow response with JSON content type
            crow::response res(405, response_json.dump(4));
            res.set_header("Content-Type", "application/json");
            return res;
        }
    });

    app.port(18083).multithreaded().run();
    return 0;
}
