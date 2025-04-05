package HwBird;

//สถานะ
public class ClassBird {
    String name ;
    int age;
    int body;
    int stomach;
    Boolean special;
    // การ input ค่าที่เราต้องการตั้ง
    public  ClassBird(String Name, int Age, int Body, int Stomach, boolean Special) {
        name = Name;
        age = Age;
        body = Body;
        stomach = Stomach;
        special = Special;

    }

    // พฤติกรรมที่ 1
    public void talk(String s) {
        System.out.println("speak : " + s);
    }

    public void talk() {
        System.out.println("age :" + age + " y");
    }

    // พฤติกรรมที่ 2
    public void eat(int food) {
        if (food <= body) {
            stomach = stomach + food;
        }
        if (stomach <= body) {
            System.out.println("weigth"+stomach);
        } else {
            stomach = 0;
            System.out.println(stomach);
        }
    }

    // พฤติกรรม ที่ 3
    public void pop(int pop) {
        if (!special && pop > 0 && pop <= stomach) {
            stomach = stomach - pop;
            System.out.println("normal " + pop);
            System.out.println("stomach " + stomach);

        } else if (special && pop > 0 && pop <= stomach) {
            stomach = stomach - pop;
            System.out.println(" food = " + pop + " g");
            System.out.println("stomach = " + stomach + " g");
        }

    }

}