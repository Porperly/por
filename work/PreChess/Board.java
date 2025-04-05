package PreChess;

public class Board {
    public char[] board = new char[10]; 

    void createBoard(){    //สร้างบอร์ด
    System.out.println("--------Board was created--------");            
    for (int i = 0; i < board.length; i++) {
        System.out.print("[ "+" ]");
      }
      System.out.println("");
    }
    void setBoard(Figure figure,int a){     //ตั้งบอร์ด
        a -= 1;
        if(board[a] == '\0'){
        System.out.println("Set up board "+figure.name+" at "+ a);
        board[a] = figure.name;
        for (int i = 0; i < board.length; i++) {
            System.out.print("[ "+board[i]+" ]");
          }
          System.out.println("");
        }else{
            System.out.println("Can't place your figure please try again!!!");
        }
    }
    void showBoard(){   //แสดงบอร์ด
        System.out.println("--------Show current location of board--------");
        for (int i = 0; i < board.length; i++) {
            System.out.print("[ "+board[i]+" ]");
          }
          System.out.println("");
    }
    void moveFigure(Figure figure,int position){    //ย้ายfigure
      position -= 1;
      if(board[position] == '\0'){
        System.out.println("Your figure move to "+position);
        board[position] = figure.name;
        for (int i = 0; i < board.length; i++) {
          System.out.print("[ "+board[i]+" ]");
        }
        System.out.println("");
      }else{
          System.out.println("Can't place your figure please try again!!!");
      }
      }

    }
