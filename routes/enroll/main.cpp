#include <chrono>
#include <ctime>
#include "src/libs/crow_all.h"
#include "src/libs/json.hpp"
#include "src/enrollment/index.h"
#include <iostream>
long long current_timestamp() {
    auto now = std::chrono::system_clock::now();
    auto duration = now.time_since_epoch();
    return std::chrono::duration_cast<std::chrono::seconds>(duration).count();
}
nlohmann::json create_response(int responseCode, const std::string& message,long long timestamp) {
    nlohmann::json response_json;
    response_json["response"]["code"] = responseCode;
    response_json["response"]["payload"]["message"] = message;
    response_json["response"]["payload"]["timestamp"] = std::to_string(timestamp);
    return response_json;
}
int main() {
    crow::SimpleApp app;
    wsDbConfig dbConfig("samplex", "msl", "BK221409", "127.0.0.1", 5432);
    wsEnroll enroll;
    CROW_ROUTE(app, "/enroll").methods(crow::HTTPMethod::Post, crow::HTTPMethod::Get)([&dbConfig, &enroll](const crow::request& req) {
        long long timestamp = current_timestamp(); // Get current timestamp
        if (req.method == crow::HTTPMethod::Post) {
            try {
                // Parse the JSON request body
                auto json_data = nlohmann::json::parse(req.body);
                std::string email = json_data["email"];
                std::string password = json_data["password"];
                int responseCode;
                std::string message;
                // Attempt to enroll the user
                if (enroll.wsEnrollUser(dbConfig, email, password)) {
                    responseCode = 1;
                    message = "success";
                } else {
                    responseCode = 0;
                    message = "failed";
                }
                nlohmann::json response_json = create_response(responseCode, message,timestamp);
                crow::response res;
                res.code = 200;
                res.set_header("Content-Type", "application/json");
                res.write(response_json.dump(4));
                return res;
            } catch (const std::exception &e) {
                nlohmann::json response_json = create_response(0, "Invalid request",timestamp);
                crow::response res;
                res.code = 400;
                res.set_header("Content-Type", "application/json");
                res.write(response_json.dump(4));
                return res;
            }
        } else {
            // Handle non-POST requests
            nlohmann::json response_json = create_response(0, "Method Not Allowed",timestamp);
            crow::response res;
            res.code = 405;
            res.set_header("Content-Type", "application/json");
            res.write(response_json.dump(4));
            return res;
        }
    });

    app.port(18084).multithreaded().run();
    return 0;
}
