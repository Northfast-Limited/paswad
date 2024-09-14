#ifndef DBCONFIG_H
#define DBCONFIG_H
#include <string>
#include <pqxx/pqxx>
class wsDbConfig {
public:
    wsDbConfig(const std::string& dbname, const std::string& user, const std::string& password, const std::string& host, int port);
    ~wsDbConfig();
    pqxx::connection* getConnection();
    bool isConnected() const;
private:
    std::string dbname_;
    std::string user_;
    std::string password_;
    std::string host_;
    int port_;
    pqxx::connection* conn_;
};
#endif

