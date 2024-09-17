#ifndef ENROLL_MANAGER_HPP
#define ENROLL_MANAGER_HPP

#include <iostream>
#include <string>
#include <vector>
#include <openssl/sha.h>
#include "../wsDbConfig/wsDbConfig.h"

class wsEnroll {
public:
    // Insert new user credentials into the database
    bool wsEnrollUser(wsDbConfig& dbConfig, const std::string& email, const std::string& password) {
        try {
            pqxx::work W(*dbConfig.getConnection());
            // Hash the password before inserting it into the database
            std::string hashed_password = hash_password(password);
            std::string query = "INSERT INTO fgg (email, password) VALUES (" + W.quote(email) + ", " + W.quote(hashed_password) + ");";
            W.exec(query);
            W.commit();
            return true;
        } catch (const std::exception &e) {
            std::cerr << "Database error: " << e.what() << std::endl;
            return false;
        }
    }
private:
    // Hash the password using SHA-256
    std::string hash_password(const std::string& password) {
        unsigned char hash[SHA256_DIGEST_LENGTH];
        SHA256(reinterpret_cast<const unsigned char*>(password.c_str()), password.size(), hash);

        std::stringstream ss;
        for (auto byte : hash) {
            ss << std::hex << std::setw(2) << std::setfill('0') << static_cast<int>(byte);
        }
        return ss.str();
    }
};
#endif
