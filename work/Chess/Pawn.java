package Chess;
public class Pawn extends Figure {

    public Pawn(String name,boolean isWhite, String currentPosition) {
        super(name, isWhite, currentPosition);
    }
    private boolean isSecondTurn;
    
    void move(Board board, String targetPosition) {
        int row = targetPosition.charAt(0) - 'a';
        int column = 8 - Character.getNumericValue(targetPosition.charAt(1));

        int deltaX = row - this.positionX;
        int deltaY = column - this.positionY;

      
        if((row< 0 || row >= 8 || (column < 0||column >=8))){
            System.out.println("Position is out of bounds");
            return;
        }
        else if((board.board[column][row] != null && board.board[column][row].isWhite == this.isWhite))      
            System.out.printf("The distination is being occupied by the same-side figure \"%s\", Command abort!!!\n\n", board.board[column][row].name);

            else if((board.board[column+1][row] != null ))      
            System.out.printf("There's a figure \\\"%s\\\" blocking the way and you can't across it , Command abort!!!\n\n", board.board[column+1][row].name);


        else if(Math.abs(deltaY) == 1 && Math.abs(deltaX) == 1&&board.board[column][row].isWhite != this.isWhite){
            board.board[positionY][positionX] = null;
            board.board[column][row] = this;
            this.positionX = row;
            this.positionY = column;
            return;
        }    

        else if(Math.abs(deltaX)>0){
            System.out.println("Can't move");
            return;
            }    
            
        else if((this.isSecondTurn==false)&&(Math.abs(deltaY)<=2)&&(deltaY<1)){
            board.board[positionY][positionX] = null;
            board.board[column][row] = this;
            this.positionX = row;
            this.positionY = column;
            this.isSecondTurn=true;
            return;
          
        }else if(this.isSecondTurn==true&&Math.abs(deltaY)==1&&deltaY<1&&board.board[column][row] == null){
            board.board[positionY][positionX] = null;
            board.board[column][row] = this;
            this.positionX = row;
            this.positionY = column;
            return;
          
         }else{
            System.out.println("Please try again!!!");
         }
        }

     
    }