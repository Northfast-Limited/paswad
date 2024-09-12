#include "db.h"
#include <iostream>

wsDbConfig::wsDbConfig(const std::string& dbname, const std::string& user, const std::string& password, const std::string& host, int port)
    : dbname_(dbname), user_(user), password_(password), host_(host), port_(port), conn_(nullptr) {
    try {
        std::string conn_str = "dbname=" + dbname_ + " user=" + user_ + " password=" + password_ + 
                               " hostaddr=" + host_ + " port=" + std::to_string(port_);
        conn_ = new pqxx::connection(conn_str);
        if (conn_->is_open()) {
            std::cout << "Connected to database: " << dbname_ << std::endl;
        } else {
            std::cerr << "Failed to connect to database." << std::endl;
        }
    } catch (const std::exception &e) {
        std::cerr << "Error: " << e.what() << std::endl;
    }
}

wsDbConfig::~wsDbConfig() {
    delete conn_;
}

pqxx::connection* wsDbConfig::getConnection() {
    return conn_;
}

bool wsDbConfig::isConnected() const {
    return conn_ && conn_->is_open();
}
