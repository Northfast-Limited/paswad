#ifndef LOGIN_MANAGER_HPP
#define LOGIN_MANAGER_HPP
#include <iostream>
#include <string>
#include <vector>
#include <openssl/sha.h>
#include "../wsDbConfig/wsDbConfig.h"
class wsLogin {
public:
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
};
#endif 
