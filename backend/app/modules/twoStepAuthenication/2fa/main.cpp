#include <iostream>
#include <stdexcept>

// Function to test
int add(int a, int b) {
    return a + b;
}

// Test function
void test_add() {
    // Test case 1
    int result = add(2, 3);
    if (result != 5) {
        throw std::logic_error("Test case 1 failed");
    }

    // Test case 2
    result = add(-1, 1);
    if (result != 0) {
        throw std::logic_error("Test case 2 failed");
    }

    // Test case 3
    result = add(0, 0);
    if (result != 0) {
        throw std::logic_error("Test case 3 failed");
    }

    // Additional test cases can be added here
}

int main() {
    try {
        // Run the tests
        test_add();
        std::cout << "All tests passed successfully!" << std::endl;
    } catch (const std::exception& e) {
        std::cerr << "Test failed: " << e.what() << std::endl;
        return 1;
    }

    return 0;
}
