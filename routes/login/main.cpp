#include "src/libs/crow_all.h"
#include "src/libs/json.hpp"
#include "src/accountCheck/index.h"
#include <iostream>
// Function to create a JSON response
nlohmann::json create_response(int responseCode, const std::string& message, int affectedRows, long long timestamp, const std::string& content) {
    nlohmann::json response_json;
    response_json["response"]["code"] = responseCode;
    response_json["response"]["payload"]["message"] = message;
    response_json["response"]["payload"]["timestamp"] = timestamp;
    response_json["response"]["payload"]["resource"] = content;
    return response_json;
}
int main() {
    crow::SimpleApp app;
    wsDbConfig dbConfig("samplex", "msl", "BK221409", "127.0.0.1", 5432);
    std::string secretKey = "mySecretKey";
    wsLogin creds;
    CROW_ROUTE(app, "/login").methods("POST"_method, "GET"_method)([&dbConfig, &creds](const crow::request& req) {
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
                if (creds.verify_credentials(dbConfig, username, password)) {
                    responseCode = 1;
                    message = "found";
                    // Call class to generate dashboard JWT and provide an API response
                    content = "<input data-timestamp='" + std::to_string(timestamp) + "' type='password' required placeholder='password' id='password'><button onclick='pwdCheckApi()'type='button' identifiertoken='" + std::to_string(timestamp) + "'>Continue</button>";
                } else {
                    responseCode = 0;
                    message = "Account not found";
                    content = ""; // Empty content
                }
                // Generate the response JSON
                nlohmann::json response_json = create_response(responseCode, message, affectedRows, timestamp, content);
                // Create a Crow response with JSON content type
                crow::response res;
                res.code = 200;
                res.set_header("Content-Type", "application/json");
                res.write(response_json.dump(4));
                return res;
            } catch (const std::exception &e) {
                // Handle exception for invalid JSON or other errors
                nlohmann::json response_json = create_response(0, "Invalid JSON format", 0, 0, "");
                crow::response res;
                res.code = 400;
                res.set_header("Content-Type", "application/json");
                res.write(response_json.dump(4));
                return res;
            }
        } else {
            // If method is not POST, return method not allowed response
            nlohmann::json response_json = create_response(0, "Method Not Allowed", 0, 0, "");
            crow::response res;
            res.code = 405;
            res.set_header("Content-Type", "application/json");
            res.write(response_json.dump(4));
            return res;
        }
    });
    app.port(18083).multithreaded().run();
    return 0;
}
