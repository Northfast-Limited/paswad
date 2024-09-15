#include <iostream>
class db {
    public: 
    //constructor default value
        db(int m,int n=2); 
   ~db();
};
db::~db() {
    // Optional: Add cleanup code if needed, or leave it empty.
}
        db::db(int m,int n){
       std::cout<<m<<n<<std::endl;
};
