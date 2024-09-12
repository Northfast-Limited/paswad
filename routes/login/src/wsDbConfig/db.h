#ifndef DBCONFIG_H
#define DBCONFIG_H

#include <string>
#include <pqxx/pqxx>

class wsDbConfig {
public:
    // Constructor
    wsDbConfig(const std::string& dbname, const std::string& user, const std::string& password, const std::string& host, int port);

    // Destructor
    ~wsDbConfig();

    // Function to get the connection object
    pqxx::connection* getConnection();

    // Function to check if connection is open
    bool isConnected() const;

private:
    std::string dbname_;
    std::string user_;
    std::string password_;
    std::string host_;
    int port_;
    pqxx::connection* conn_;
};

#endif // DBCONFIG_H
