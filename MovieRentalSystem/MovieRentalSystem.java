import javax.swing.*;
import java.awt.*;
import java.awt.event.*;
import java.util.*;
import java.util.List;

public class MovieRentalSystem {
    // Data storage using collections
    private static Map<Integer, User> users = new HashMap<>();
    private static List<Movie> movies = new ArrayList<>();
    private static List<Rental> rentals = new ArrayList<>();
    private static int rentalIdCounter = 1;
    private static int userIdCounter = 1;

    public static void main(String[] args) {
        // Initialize data
        initializeData();
        // Display login window
        showLoginWindow();
    }

    // Initialize sample data
    private static void initializeData() {
        // Create users
        users.put(userIdCounter++, new User(1, "manager", "manager123", "Manager"));
        users.put(userIdCounter++, new User(2, "staff", "staff123", "Staff"));
        users.put(userIdCounter++, new User(3, "customer1", "customer123", "Customer"));
        users.put(userIdCounter++, new User(4, "customer2", "customer456", "Customer"));

        // Create movies
        movies.add(new Movie(1, "Inception", 5, 3.50));
        movies.add(new Movie(2, "The Matrix", 3, 4.00));
        movies.add(new Movie(3, "The Dark Knight", 7, 2.75));
    }

    // Show login window
    private static void showLoginWindow() {
        JFrame frame = new JFrame("Movie Rental System");
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.setSize(400, 250);
        frame.setLocationRelativeTo(null); // Center on screen

        JPanel panel = new JPanel(new GridBagLayout());
        GridBagConstraints gbc = new GridBagConstraints();
        gbc.insets = new Insets(5, 5, 5, 5);
        gbc.fill = GridBagConstraints.HORIZONTAL;

        // Create components
        JLabel titleLabel = new JLabel("Welcome to Movie Rental System!", JLabel.CENTER);
        titleLabel.setFont(new Font("Arial", Font.BOLD, 16));
        JLabel usernameLabel = new JLabel("Username:");
        JLabel passwordLabel = new JLabel("Password:");
        JTextField usernameField = new JTextField(15);
        JPasswordField passwordField = new JPasswordField(15);
        JButton loginButton = new JButton("Login");

        // Add components with proper layout
        gbc.gridx = 0;
        gbc.gridy = 0;
        gbc.gridwidth = 2;
        panel.add(titleLabel, gbc);

        gbc.gridy = 1;
        gbc.gridwidth = 1;
        panel.add(usernameLabel, gbc);

        gbc.gridx = 1;
        panel.add(usernameField, gbc);

        gbc.gridx = 0;
        gbc.gridy = 2;
        panel.add(passwordLabel, gbc);

        gbc.gridx = 1;
        panel.add(passwordField, gbc);

        gbc.gridx = 0;
        gbc.gridy = 3;
        gbc.gridwidth = 2;
        gbc.anchor = GridBagConstraints.CENTER;
        panel.add(loginButton, gbc);

        // Login action
        loginButton.addActionListener(e -> {
            String username = usernameField.getText();
            String password = new String(passwordField.getPassword());

            User currentUser = login(username, password);
            if (currentUser != null) {
                JOptionPane.showMessageDialog(frame, "Login successful! Welcome, " + currentUser.username);
                frame.dispose();
                showUserInterface(currentUser);
            } else {
                JOptionPane.showMessageDialog(frame, "Invalid username or password. Try again.");
            }
        });

        frame.add(panel);
        frame.setVisible(true);
    }

    // Login validation
    private static User login(String username, String password) {
        return users.values().stream()
                .filter(user -> user.username.equals(username) && user.password.equals(password))
                .findFirst()
                .orElse(null);
    }

    // Show user interface based on role
    private static void showUserInterface(User user) {
        JFrame frame = new JFrame(user.username + " - " + user.role);
        frame.setSize(450, 350);
        frame.setLocationRelativeTo(null);
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);

        JPanel panel = new JPanel();
        panel.setLayout(new BoxLayout(panel, BoxLayout.Y_AXIS));
        panel.setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));

        // Add role-specific buttons
        switch (user.role) {
            case "Manager":
                addManagerOptions(panel, frame, user);  // Pass the user parameter
                break;
            case "Staff":
                addStaffOptions(panel, frame);
                break;
            case "Customer":
                addCustomerOptions(panel, frame, user);
                break;
        }

        // Common logout button
        JButton logoutButton = new JButton("Logout");
        logoutButton.setAlignmentX(Component.CENTER_ALIGNMENT);
        logoutButton.setMaximumSize(new Dimension(150, 30));
        logoutButton.addActionListener(e -> {
            frame.dispose();
            showLoginWindow();
        });

        panel.add(Box.createVerticalStrut(10));
        panel.add(logoutButton);

        frame.add(new JScrollPane(panel));
        frame.setVisible(true);
    }

    // Manager options
    private static void addManagerOptions(JPanel panel, JFrame parentFrame, User user){
        String[] buttonLabels = {
                "Add User", "Edit User", "Delete User", "View Users",
                "View Movies", "View Rentals", "Calculate Total Revenue"
        };

        for (String label : buttonLabels) {
            JButton button = createStyledButton(label);
            panel.add(button);
            panel.add(Box.createVerticalStrut(5));

            switch (label) {
                case "Add User":
                    button.addActionListener(e -> addUser(parentFrame));
                    break;
                case "Edit User":
                    button.addActionListener(e -> editUser(parentFrame));
                    break;
                case "Delete User":
                    button.addActionListener(e -> deleteUser(parentFrame, user));  // Pass the user parameter
                    break;
                case "View Users":
                    button.addActionListener(e -> viewUsers(parentFrame));
                    break;
                case "View Movies":
                    button.addActionListener(e -> viewMovies(parentFrame));
                    break;
                case "View Rentals":
                    button.addActionListener(e -> viewRentals(parentFrame));
                    break;
                case "Calculate Total Revenue":
                    button.addActionListener(e -> calculateRevenue(parentFrame));
                    break;
            }
        }
    }

    // Staff options
    private static void addStaffOptions(JPanel panel, JFrame parentFrame) {
        String[] buttonLabels = {
                "View Movies", "Add Movie", "Edit Movie", "Delete Movie",
                "View Users", "Add Customer", "Edit Customer", "Delete Customer"
        };

        for (String label : buttonLabels) {
            JButton button = createStyledButton(label);
            panel.add(button);
            panel.add(Box.createVerticalStrut(5));

            switch (label) {
                case "View Movies":
                    button.addActionListener(e -> viewMovies(parentFrame));
                    break;
                case "Add Movie":
                    button.addActionListener(e -> addMovie(parentFrame));
                    break;
                case "Edit Movie":
                    button.addActionListener(e -> editMovie(parentFrame));
                    break;
                case "Delete Movie":
                    button.addActionListener(e -> deleteMovie(parentFrame));
                    break;
                case "View Users":
                    button.addActionListener(e -> viewCustomers(parentFrame));
                    break;
                case "Add Customer":
                    button.addActionListener(e -> addCustomer(parentFrame));
                    break;
                case "Edit Customer":
                    button.addActionListener(e -> editCustomer(parentFrame));
                    break;
                case "Delete Customer":
                    button.addActionListener(e -> deleteCustomer(parentFrame));
                    break;
            }
        }
    }

    // Customer options
    private static void addCustomerOptions(JPanel panel, JFrame parentFrame, User user) {
        String[] buttonLabels = {
                "View Available Movies", "Rent Movie", "View My Rentals", "Return Movie"
        };

        for (String label : buttonLabels) {
            JButton button = createStyledButton(label);
            panel.add(button);
            panel.add(Box.createVerticalStrut(5));

            switch (label) {
                case "View Available Movies":
                    button.addActionListener(e -> viewAvailableMovies(parentFrame));
                    break;
                case "Rent Movie":
                    button.addActionListener(e -> rentMovie(parentFrame, user));
                    break;
                case "View My Rentals":
                    button.addActionListener(e -> viewMyRentals(parentFrame, user));
                    break;
                case "Return Movie":
                    button.addActionListener(e -> returnMovie(parentFrame, user));
                    break;
            }
        }
    }

    // Create consistently styled buttons
    private static JButton createStyledButton(String text) {
        JButton button = new JButton(text);
        button.setAlignmentX(Component.CENTER_ALIGNMENT);
        button.setMaximumSize(new Dimension(200, 30));
        return button;
    }

    // User management methods
    private static void addUser(JFrame parentFrame) {
        JTextField usernameField = new JTextField();
        JPasswordField passwordField = new JPasswordField();
        String[] roles = {"Manager", "Staff", "Customer"};
        JComboBox<String> roleComboBox = new JComboBox<>(roles);

        Object[] message = {
                "Username:", usernameField,
                "Password:", passwordField,
                "Role:", roleComboBox
        };

        int option = JOptionPane.showConfirmDialog(parentFrame, message, "Add User", JOptionPane.OK_CANCEL_OPTION);
        if (option == JOptionPane.OK_OPTION) {
            String username = usernameField.getText();
            String password = new String(passwordField.getPassword());
            String role = (String) roleComboBox.getSelectedItem();

            if (!username.isEmpty() && !password.isEmpty()) {
                users.put(userIdCounter, new User(userIdCounter, username, password, role));
                userIdCounter++;
                JOptionPane.showMessageDialog(parentFrame, "User added successfully.");
            } else {
                JOptionPane.showMessageDialog(parentFrame, "Username and password cannot be empty.");
            }
        }
    }

    private static void editUser(JFrame parentFrame) {
        // Create array of user IDs for dropdown
        Integer[] userIds = users.keySet().toArray(new Integer[0]);
        JComboBox<Integer> userComboBox = new JComboBox<>(userIds);

        int option = JOptionPane.showConfirmDialog(parentFrame, userComboBox, "Select User to Edit", JOptionPane.OK_CANCEL_OPTION);
        if (option == JOptionPane.OK_OPTION && userComboBox.getSelectedItem() != null) {
            int userId = (Integer) userComboBox.getSelectedItem();
            User user = users.get(userId);

            JTextField usernameField = new JTextField(user.username);
            JPasswordField passwordField = new JPasswordField(user.password);
            String[] roles = {"Manager", "Staff", "Customer"};
            JComboBox<String> roleComboBox = new JComboBox<>(roles);
            roleComboBox.setSelectedItem(user.role);

            Object[] message = {
                    "Username:", usernameField,
                    "Password:", passwordField,
                    "Role:", roleComboBox
            };

            option = JOptionPane.showConfirmDialog(parentFrame, message, "Edit User", JOptionPane.OK_CANCEL_OPTION);
            if (option == JOptionPane.OK_OPTION) {
                user.username = usernameField.getText();
                user.password = new String(passwordField.getPassword());
                user.role = (String) roleComboBox.getSelectedItem();
                JOptionPane.showMessageDialog(parentFrame, "User updated successfully.");
            }
        }
    }

    private static void deleteUser(JFrame parentFrame, User currentUser) {  // Add currentUser parameter
        Integer[] userIds = users.keySet().toArray(new Integer[0]);
        JComboBox<Integer> userComboBox = new JComboBox<>(userIds);
        int option = JOptionPane.showConfirmDialog(parentFrame, userComboBox, "Select User to Delete", JOptionPane.OK_CANCEL_OPTION);
        if (option == JOptionPane.OK_OPTION && userComboBox.getSelectedItem() != null) {
            int userId = (Integer) userComboBox.getSelectedItem();

            // Check if user is trying to delete themselves
            if (userId == currentUser.id) {
                JOptionPane.showMessageDialog(parentFrame,
                        "You cannot delete your own account while logged in.",
                        "Operation Not Allowed", JOptionPane.ERROR_MESSAGE);
                return;
            }

            option = JOptionPane.showConfirmDialog(parentFrame,
                    "Are you sure you want to delete user ID: " + userId + "?",
                    "Confirm Deletion", JOptionPane.YES_NO_OPTION);

            if (option == JOptionPane.YES_OPTION) {
                users.remove(userId);
                JOptionPane.showMessageDialog(parentFrame, "User deleted successfully.");
            }
        }
    }

    private static void viewUsers(JFrame parentFrame) {
        displayTable(parentFrame, "Users",
                new String[]{"ID", "Username", "Role"},
                users.values().stream()
                        .map(user -> new Object[]{user.id, user.username, user.role})
                        .toArray(Object[][]::new)
        );
    }

    private static void viewCustomers(JFrame parentFrame) {
        displayTable(parentFrame, "Customers",
                new String[]{"ID", "Username"},
                users.values().stream()
                        .filter(user -> user.role.equals("Customer"))
                        .map(user -> new Object[]{user.id, user.username})
                        .toArray(Object[][]::new)
        );
    }

    // Movie management methods
    private static void addMovie(JFrame parentFrame) {
        JTextField titleField = new JTextField();
        JSpinner quantitySpinner = new JSpinner(new SpinnerNumberModel(1, 1, 100, 1));
        JSpinner feeSpinner = new JSpinner(new SpinnerNumberModel(2.0, 0.5, 20.0, 0.5));

        Object[] message = {
                "Movie Title:", titleField,
                "Quantity:", quantitySpinner,
                "Rental Fee ($):", feeSpinner
        };

        int option = JOptionPane.showConfirmDialog(parentFrame, message, "Add Movie", JOptionPane.OK_CANCEL_OPTION);
        if (option == JOptionPane.OK_OPTION) {
            String title = titleField.getText();
            int quantity = (Integer) quantitySpinner.getValue();
            double fee = (Double) feeSpinner.getValue();

            if (!title.isEmpty()) {
                int id = movies.isEmpty() ? 1 : movies.get(movies.size() - 1).id + 1;
                movies.add(new Movie(id, title, quantity, fee));
                JOptionPane.showMessageDialog(parentFrame, "Movie added successfully.");
            } else {
                JOptionPane.showMessageDialog(parentFrame, "Movie title cannot be empty.");
            }
        }
    }

    private static void editMovie(JFrame parentFrame) {
        // Create array of movie titles for dropdown
        String[] movieTitles = movies.stream()
                .map(movie -> movie.id + ": " + movie.title)
                .toArray(String[]::new);

        JComboBox<String> movieComboBox = new JComboBox<>(movieTitles);

        int option = JOptionPane.showConfirmDialog(parentFrame, movieComboBox, "Select Movie to Edit", JOptionPane.OK_CANCEL_OPTION);
        if (option == JOptionPane.OK_OPTION && movieComboBox.getSelectedItem() != null) {
            int index = movieComboBox.getSelectedIndex();
            Movie movie = movies.get(index);

            JTextField titleField = new JTextField(movie.title);
            JSpinner quantitySpinner = new JSpinner(new SpinnerNumberModel(movie.quantity, 0, 100, 1));
            JSpinner feeSpinner = new JSpinner(new SpinnerNumberModel(movie.rentalFee, 0.5, 20.0, 0.5));

            Object[] message = {
                    "Movie Title:", titleField,
                    "Quantity:", quantitySpinner,
                    "Rental Fee ($):", feeSpinner
            };

            option = JOptionPane.showConfirmDialog(parentFrame, message, "Edit Movie", JOptionPane.OK_CANCEL_OPTION);
            if (option == JOptionPane.OK_OPTION) {
                movie.title = titleField.getText();
                movie.quantity = (Integer) quantitySpinner.getValue();
                movie.rentalFee = (Double) feeSpinner.getValue();
                JOptionPane.showMessageDialog(parentFrame, "Movie updated successfully.");
            }
        }
    }

    private static void deleteMovie(JFrame parentFrame) {
        String[] movieTitles = movies.stream()
                .map(movie -> movie.id + ": " + movie.title)
                .toArray(String[]::new);

        JComboBox<String> movieComboBox = new JComboBox<>(movieTitles);

        int option = JOptionPane.showConfirmDialog(parentFrame, movieComboBox, "Select Movie to Delete", JOptionPane.OK_CANCEL_OPTION);
        if (option == JOptionPane.OK_OPTION && movieComboBox.getSelectedItem() != null) {
            int index = movieComboBox.getSelectedIndex();
            Movie movie = movies.get(index);

            option = JOptionPane.showConfirmDialog(parentFrame,
                    "Are you sure you want to delete movie: " + movie.title + "?",
                    "Confirm Deletion", JOptionPane.YES_NO_OPTION);

            if (option == JOptionPane.YES_OPTION) {
                movies.remove(movie);
                JOptionPane.showMessageDialog(parentFrame, "Movie deleted successfully.");
            }
        }
    }

    private static void viewMovies(JFrame parentFrame) {
        displayTable(parentFrame, "All Movies",
                new String[]{"ID", "Title", "Quantity", "Rental Fee"},
                movies.stream()
                        .map(movie -> new Object[]{movie.id, movie.title, movie.quantity, "$" + movie.rentalFee})
                        .toArray(Object[][]::new)
        );
    }

    private static void viewAvailableMovies(JFrame parentFrame) {
        displayTable(parentFrame, "Available Movies",
                new String[]{"ID", "Title", "Quantity", "Rental Fee"},
                movies.stream()
                        .filter(movie -> movie.quantity > 0)
                        .map(movie -> new Object[]{movie.id, movie.title, movie.quantity, "$" + movie.rentalFee})
                        .toArray(Object[][]::new)
        );
    }

    // Customer management methods
    private static void addCustomer(JFrame parentFrame) {
        JTextField usernameField = new JTextField();
        JPasswordField passwordField = new JPasswordField();

        Object[] message = {
                "Username:", usernameField,
                "Password:", passwordField
        };

        int option = JOptionPane.showConfirmDialog(parentFrame, message, "Add Customer", JOptionPane.OK_CANCEL_OPTION);
        if (option == JOptionPane.OK_OPTION) {
            String username = usernameField.getText();
            String password = new String(passwordField.getPassword());

            if (!username.isEmpty() && !password.isEmpty()) {
                users.put(userIdCounter, new User(userIdCounter, username, password, "Customer"));
                userIdCounter++;
                JOptionPane.showMessageDialog(parentFrame, "Customer added successfully.");
            } else {
                JOptionPane.showMessageDialog(parentFrame, "Username and password cannot be empty.");
            }
        }
    }

    private static void editCustomer(JFrame parentFrame) {
        // Filter to show only customers
        Integer[] customerIds = users.values().stream()
                .filter(user -> user.role.equals("Customer"))
                .map(user -> user.id)
                .toArray(Integer[]::new);

        JComboBox<Integer> customerComboBox = new JComboBox<>(customerIds);

        int option = JOptionPane.showConfirmDialog(parentFrame, customerComboBox, "Select Customer to Edit", JOptionPane.OK_CANCEL_OPTION);
        if (option == JOptionPane.OK_OPTION && customerComboBox.getSelectedItem() != null) {
            int userId = (Integer) customerComboBox.getSelectedItem();
            User user = users.get(userId);

            JTextField usernameField = new JTextField(user.username);
            JPasswordField passwordField = new JPasswordField(user.password);

            Object[] message = {
                    "Username:", usernameField,
                    "Password:", passwordField
            };

            option = JOptionPane.showConfirmDialog(parentFrame, message, "Edit Customer", JOptionPane.OK_CANCEL_OPTION);
            if (option == JOptionPane.OK_OPTION) {
                user.username = usernameField.getText();
                user.password = new String(passwordField.getPassword());
                JOptionPane.showMessageDialog(parentFrame, "Customer updated successfully.");
            }
        }
    }

    private static void deleteCustomer(JFrame parentFrame) {
        Integer[] customerIds = users.values().stream()
                .filter(user -> user.role.equals("Customer"))
                .map(user -> user.id)
                .toArray(Integer[]::new);

        JComboBox<Integer> customerComboBox = new JComboBox<>(customerIds);

        int option = JOptionPane.showConfirmDialog(parentFrame, customerComboBox, "Select Customer to Delete", JOptionPane.OK_CANCEL_OPTION);
        if (option == JOptionPane.OK_OPTION && customerComboBox.getSelectedItem() != null) {
            int userId = (Integer) customerComboBox.getSelectedItem();

            option = JOptionPane.showConfirmDialog(parentFrame,
                    "Are you sure you want to delete customer ID: " + userId + "?",
                    "Confirm Deletion", JOptionPane.YES_NO_OPTION);

            if (option == JOptionPane.YES_OPTION) {
                users.remove(userId);
                JOptionPane.showMessageDialog(parentFrame, "Customer deleted successfully.");
            }
        }
    }

    // Rental management methods
    private static void rentMovie(JFrame parentFrame, User user) {
        // Only show available movies
        String[] availableMovies = movies.stream()
                .filter(movie -> movie.quantity > 0)
                .map(movie -> movie.id + ": " + movie.title + " ($" + movie.rentalFee + "/day)")
                .toArray(String[]::new);

        if (availableMovies.length == 0) {
            JOptionPane.showMessageDialog(parentFrame, "No movies available for rent.");
            return;
        }

        JComboBox<String> movieComboBox = new JComboBox<>(availableMovies);
        JSpinner daysSpinner = new JSpinner(new SpinnerNumberModel(1, 1, 30, 1));

        Object[] message = {
                "Select Movie:", movieComboBox,
                "Rental Days:", daysSpinner
        };

        int option = JOptionPane.showConfirmDialog(parentFrame, message, "Rent Movie", JOptionPane.OK_CANCEL_OPTION);
        if (option == JOptionPane.OK_OPTION && movieComboBox.getSelectedItem() != null) {
            int index = movieComboBox.getSelectedIndex();

            // Get available movies again and select the one at the chosen index
            Movie movie = movies.stream()
                    .filter(m -> m.quantity > 0)
                    .toArray(Movie[]::new)[index];

            int days = (Integer) daysSpinner.getValue();
            double fee = movie.rentalFee * days;

            // Create rental
            rentals.add(new Rental(rentalIdCounter++, user.id, movie.id, fee));

            // Decrease movie quantity
            movie.quantity--;

            JOptionPane.showMessageDialog(parentFrame,
                    "Movie rented successfully!\n" +
                            "Title: " + movie.title + "\n" +
                            "Days: " + days + "\n" +
                            "Total Fee: $" + String.format("%.2f", fee));
        }
    }

    // Then, modify the returnMovie method to mark rentals as returned instead of removing them
    private static void returnMovie(JFrame parentFrame, User user) {
        // Get user's active rentals
        List<Rental> userRentals = rentals.stream()
                .filter(rental -> rental.userId == user.id && rental.active)  // Only show active rentals
                .toList();

        if (userRentals.isEmpty()) {
            JOptionPane.showMessageDialog(parentFrame, "You have no movies to return.");
            return;
        }

        // Create rental options for dropdown
        String[] rentalOptions = userRentals.stream()
                .map(rental -> {
                    Movie movie = findMovieById(rental.movieId);
                    return "ID: " + rental.id + " - " + (movie != null ? movie.title : "Unknown") +
                            " ($" + String.format("%.2f", rental.rentalFee) + ")";
                })
                .toArray(String[]::new);

        JComboBox<String> rentalComboBox = new JComboBox<>(rentalOptions);

        int option = JOptionPane.showConfirmDialog(parentFrame, rentalComboBox, "Select Movie to Return", JOptionPane.OK_CANCEL_OPTION);
        if (option == JOptionPane.OK_OPTION && rentalComboBox.getSelectedItem() != null) {
            int index = rentalComboBox.getSelectedIndex();
            Rental rental = userRentals.get(index);

            // Find the movie and increase quantity
            Movie movie = findMovieById(rental.movieId);
            if (movie != null) {
                movie.quantity++;
            }

            // Mark the rental as inactive (returned) instead of removing it
            rental.active = false;

            JOptionPane.showMessageDialog(parentFrame, "Movie returned successfully.");
        }
    }

    // Update viewRentals to show the status for all rentals
    private static void viewRentals(JFrame parentFrame) {
        displayTable(parentFrame, "All Rentals",
                new String[]{"ID", "User", "Movie", "Fee", "Status"},
                rentals.stream()
                        .map(rental -> {
                            User user = users.get(rental.userId);
                            Movie movie = findMovieById(rental.movieId);
                            return new Object[]{
                                    rental.id,
                                    user != null ? user.username : "Unknown",
                                    movie != null ? movie.title : "Unknown",
                                    "$" + String.format("%.2f", rental.rentalFee),
                                    rental.active ? "Active" : "Returned"
                            };
                        })
                        .toArray(Object[][]::new)
        );
    }

    // Update viewMyRentals to show only active rentals
    private static void viewMyRentals(JFrame parentFrame, User user) {
        displayTable(parentFrame, "My Rentals",
                new String[]{"ID", "Movie", "Fee", "Status"},
                rentals.stream()
                        .filter(rental -> rental.userId == user.id)
                        .map(rental -> {
                            Movie movie = findMovieById(rental.movieId);
                            return new Object[]{
                                    rental.id,
                                    movie != null ? movie.title : "Unknown",
                                    "$" + String.format("%.2f", rental.rentalFee),
                                    rental.active ? "Active" : "Returned"
                            };
                        })
                        .toArray(Object[][]::new)
        );
    }

    // The calculateRevenue method stays the same, but now includes both active and returned rentals
    private static void calculateRevenue(JFrame parentFrame) {
        double totalRevenue = rentals.stream()
                .mapToDouble(rental -> rental.rentalFee)
                .sum();

        // Add additional information about active vs. returned rentals
        long activeRentals = rentals.stream().filter(r -> r.active).count();
        long returnedRentals = rentals.stream().filter(r -> !r.active).count();

        JOptionPane.showMessageDialog(parentFrame,
                "Total Revenue: $" + String.format("%.2f", totalRevenue) + "\n" +
                        "Total Rentals: " + rentals.size() + "\n" +
                        "Active Rentals: " + activeRentals + "\n" +
                        "Returned Rentals: " + returnedRentals);
    }

    // Helper methods
    private static Movie findMovieById(int id) {
        return movies.stream()
                .filter(movie -> movie.id == id)
                .findFirst()
                .orElse(null);
    }

    // Display data in table format
    private static void displayTable(JFrame parentFrame, String title, String[] columnNames, Object[][] data) {
        JTable table = new JTable(data, columnNames);
        JScrollPane scrollPane = new JScrollPane(table);
        scrollPane.setPreferredSize(new Dimension(500, 300));

        JDialog dialog = new JDialog(parentFrame, title, true);
        dialog.setLayout(new BorderLayout());
        dialog.add(scrollPane, BorderLayout.CENTER);

        JButton closeButton = new JButton("Close");
        closeButton.addActionListener(e -> dialog.dispose());

        JPanel buttonPanel = new JPanel();
        buttonPanel.add(closeButton);
        dialog.add(buttonPanel, BorderLayout.SOUTH);

        dialog.pack();
        dialog.setLocationRelativeTo(parentFrame);
        dialog.setVisible(true);
    }
}