#ifndef LOGIN_MANAGER_HPP
#define LOGIN_MANAGER_HPP
#include <iostream>
#include <string>
#include <vector>
#include <openssl/sha.h>
#include "../wsDbConfig/wsDbConfig.h"
// Helper function to hash a password using SHA-256
std::string hash_password(const std::string& password) {
    unsigned char hash[SHA256_DIGEST_LENGTH];
    SHA256(reinterpret_cast<const unsigned char*>(password.c_str()), password.size(), hash);

    // Convert hash to a hexadecimal string
    std::string hashed_password;
    for (int i = 0; i < SHA256_DIGEST_LENGTH; ++i) {
        char buffer[3];
        snprintf(buffer, sizeof(buffer), "%02x", hash[i]);
        hashed_password += buffer;
    }

    return hashed_password;
}
class wsLogin {
public:
    bool verify_credentials(wsDbConfig& dbConfig, const std::string& username, const std::string& password) {
        try {
            pqxx::work W(*dbConfig.getConnection());
            
            // Hash the input password
            std::string hashed_password = hash_password(password);
            
            // Fetch the stored hashed password from the database
            std::string query = "SELECT password FROM fgg WHERE username = " + W.quote(username) + ";";
            pqxx::result R = W.exec(query);

            // Check if the result is not empty and compare the hashed password
            if (!R.empty()) {
                std::string stored_hashed_password = R[0][0].as<std::string>();
                return stored_hashed_password == hashed_password;
            } else {
                return false;
            }
        } catch (const std::exception &e) {
            std::cerr << "Database error: " << e.what() << std::endl;
            return false;
        }
    }
};

#endif // LOGIN_MANAGER_HPP
