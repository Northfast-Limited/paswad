#ifndef WSNOTA_HPP
#define WSNOTA_HPP

#include <iostream>
#include <string>
#include <boost/asio.hpp>
#include <boost/asio/ssl.hpp>
#include <boost/beast/core.hpp>
#include <boost/beast/http.hpp>
#include <boost/beast/version.hpp>
#include <boost/system/error_code.hpp>

class wsNota {
public:
    wsNota(const std::string& smtp_server, const std::string& port,
           const std::string& username, const std::string& password)
        : smtp_server_(smtp_server), port_(port), username_(username), password_(password) {
    }

    bool send_registration_notification(const std::string& to_email, const std::string& subject, const std::string& body) {
        try {
            // Initialize Boost Asio
            boost::asio::io_context io_context;
            boost::asio::ip::tcp::resolver resolver(io_context);
            boost::asio::ssl::context ssl_context(boost::asio::ssl::context::tlsv12);

            // Resolve the SMTP server address
            auto endpoints = resolver.resolve(smtp_server_, port_);
            boost::asio::ssl::stream<boost::asio::ip::tcp::socket> socket(io_context, ssl_context);
            boost::asio::connect(socket.lowest_layer(), endpoints);

            // Handshake with the server
            socket.handshake(boost::asio::ssl::stream_base::client);

            // Compose the email message
            std::string message = "To: " + to_email + "\r\n" +
                                  "From: " + username_ + "\r\n" +
                                  "Subject: " + subject + "\r\n" +
                                  "\r\n" +
                                  body + "\r\n";

            // Send the email
            boost::asio::write(socket, boost::asio::buffer(message));

            // Close the connection
            socket.lowest_layer().shutdown(boost::asio::ip::tcp::socket::shutdown_both);
            return true;
        } catch (const std::exception& e) {
            std::cerr << "wsNota error: " << e.what() << std::endl;
            return false;
        }
    }

private:
    std::string smtp_server_;
    std::string port_;
    std::string username_;
    std::string password_;
};

#endif
