package HwBook;

public class Book {
    private int numPages;
    private int currentPage;
    private int bookmarkPage;

    public Book(int numPages) {
        this.numPages = numPages;
        this.currentPage = 1;
        this.bookmarkPage = -1; // เริ่มต้นด้วยค่า -1 แสดงว่ายังไม่ได้ตั้งค่าหน้าที่คั่นหนังสือ
    }

    public void setBookmarkPage(int pageNumber) {
        if (pageNumber >= 1 && pageNumber <= numPages) {
            this.bookmarkPage = pageNumber;
            System.out.println("Set bookmark page to " + this.bookmarkPage);
        } else {
            System.out.println("Invalid page number for bookmark");
        }
    }

    public void goToBookmarkPage() {
        if (this.bookmarkPage != -1) {
            this.currentPage = this.bookmarkPage;
            System.out.println("Went to bookmarked page: " + this.currentPage);
        } else {
            System.out.println("Bookmark page is not set");
        }
    }

    public void goToPage(int pageNumber) {
        if (pageNumber >= 1 && pageNumber <= numPages) {
            this.currentPage = pageNumber;
            System.out.println("Went to page " + this.currentPage);
        } else {
            System.out.println("Invalid page number");
        }
    }

    public void goToFirstPage() {
        this.currentPage = 1;
        System.out.println("Went to the first page: " + this.currentPage);
    }

    public void goToLastPage() {
        this.currentPage = numPages;
        System.out.println("Went to the last page: " + this.currentPage);
    }

    public void nextPage() {
        if (this.currentPage < numPages) {
            this.currentPage++;
            System.out.println("Next page: " + this.currentPage);
        } else {
            System.out.println("You are already on the last page");
        }
    }

    public void previousPage() {
        if (this.currentPage > 1) {
            this.currentPage--;
            System.out.println("Previous page: " + this.currentPage);
        } else {
            System.out.println("You are already on the first page");
        }
    }

    public void showCurrentPage() {
        System.out.println("Current page: " + this.currentPage);
    }

    public void showPageNumbers() {
        System.out.println("Total number of pages: " + this.numPages);
    }
}