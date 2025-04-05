package PreChess;

public class Main {
    public static void main(String[] args) {
        // สร้างอ็อบเจ็กต์ของคลาส Figure
        Figure king = new Figure();
        king.createFigure('M'); 

        // สร้างอ็อบเจ็กต์ของคลาส Board
        Board chessBoard = new Board();
        chessBoard.createBoard(); // สร้างบอร์ด

        // ตั้งตำแหน่งบนบอร์ด
        chessBoard.setBoard(king, 5); // ตั้งที่ตำแหน่งที่ 4

        // แสดงบอร์ดที่มีอยู่
        chessBoard.showBoard();

        // ย้ายไปยังตำแหน่งใหม่
        chessBoard.moveFigure(king, 7); // ย้ายไปที่ตำแหน่งที่ 6
    }
}