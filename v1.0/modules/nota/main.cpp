#include <iostream>
#include <curl/curl.h>

static const char* payload_text[] = {
    "To: recipient@example.com\r\n",
    "From: sender@example.com\r\n",
    "Subject: Test Email\r\n",
    "\r\n", // Blank line separates headers from the body
    "This is a test email sent from a C++ program.\r\n",
    NULL
};

struct upload_status {
    int lines_read;
};

static size_t payload_source(void* ptr, size_t size, size_t nmemb, void* userp) {
    struct upload_status* upload_ctx = (struct upload_status*)userp;
    const char* data;

    if ((size == 0) || (nmemb == 0) || ((size * nmemb) < 1)) {
        return 0;
    }

    data = payload_text[upload_ctx->lines_read];

    if (data) {
        size_t len = strlen(data);
        memcpy(ptr, data, len);
        upload_ctx->lines_read++;
        return len;
    }

    return 0;
}

int main() {
    CURL* curl;
    CURLcode res = CURLE_OK;
    struct curl_slist* recipients = NULL;
    struct upload_status upload_ctx = {0};

    curl = curl_easy_init();
    if (curl) {
        curl_easy_setopt(curl, CURLOPT_USERNAME, "your_email@example.com");
        curl_easy_setopt(curl, CURLOPT_PASSWORD, "your_email_password");
        curl_easy_setopt(curl, CURLOPT_URL, "smtp://smtp.example.com:587");

        curl_easy_setopt(curl, CURLOPT_MAIL_FROM, "<sender@example.com>");
        recipients = curl_slist_append(recipients, "<recipient@example.com>");
        curl_easy_setopt(curl, CURLOPT_MAIL_RCPT, recipients);

        curl_easy_setopt(curl, CURLOPT_READFUNCTION, payload_source);
        curl_easy_setopt(curl, CURLOPT_READDATA, &upload_ctx);
        curl_easy_setopt(curl, CURLOPT_UPLOAD, 1L);

        res = curl_easy_perform(curl);

        if (res != CURLE_OK) {
            std::cerr << "curl_easy_perform() failed: " << curl_easy_strerror(res) << std::endl;
        }

        curl_slist_free_all(recipients);
        curl_easy_cleanup(curl);
    }

    return 0;
}
