package HwBook;

import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);

        System.out.print("Enter the number of pages in the book: ");
        int totalPages = scanner.nextInt();

        Book myBook = new Book(totalPages);

        System.out.println("\nPlease select an option:");
        System.out.println("1. Go to the first page");
        System.out.println("2. Go to a specific page");
        System.out.println("3. Go to the last page");
        System.out.println("4. Go to the next page");
        System.out.println("5. Go to the previous page");
        System.out.println("6. Set bookmark page");
        System.out.println("7. Go to bookmarked page");
        System.out.println("8. Show the total number of pages");
        System.out.println("9. Show the current page");
        System.out.println("0. Exit");

        int choice;
        do {
            System.out.print("\nEnter your choice: ");
            choice = scanner.nextInt();

            switch (choice) {
                case 1:
                    myBook.goToFirstPage();
                    break;
                case 2:
                    System.out.print("Enter the desired page: ");
                    int desiredPage = scanner.nextInt();
                    myBook.goToPage(desiredPage);
                    break;
                case 3:
                    myBook.goToLastPage();
                    break;
                case 4:
                    myBook.nextPage();
                    break;
                case 5:
                    myBook.previousPage();
                    break;
                case 6:
                    System.out.print("Enter the page number to set as bookmark: ");
                    int bookmarkPage = scanner.nextInt();
                    myBook.setBookmarkPage(bookmarkPage);
                    break;
                case 7:
                    myBook.goToBookmarkPage();
                    break;
                case 8:
                    myBook.showPageNumbers();
                    break;
                case 9:
                    myBook.showCurrentPage();
                    break;
                case 0:
                    System.out.println("Exiting the program");
                    break;
                default:
                    System.out.println("Please enter a valid choice");
                    break;
            }
        } while (choice != 0);

        scanner.close();
    }
}