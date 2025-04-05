package HourGlass;

public class HourGlass {
    int sandA = 5000, sandB = 0;
    int degree = 0;

    void recommend() {
        System.out.println("The hourglass will stand upright with all the sand on side A, with a total of 5000 grains of sand.");
    }

    void rotateRight90() {
        if (degree < 360) {
            degree += 90;
        } else
            degree = 0;
        System.out.println("rotate : " + degree);
    }

    void rotateRight180() {
        if (degree < 360 && degree != 270) {
            degree += 180;
        } else if (degree == 270) {
            degree = 90;
        } else
            degree = 0;
        System.out.println("rotate : " + degree);
    }

    void sand() {
        if (degree == 0 && sandB == 0) {

            for (sandA = 5000; sandA > 0; sandA -= 1000, sandB += 1000) {
                System.out.println("SandA = " + sandA + " SandB = " + sandB);
                sleep(1000);
            }
            System.out.println("SandA = " + sandA + " SandB = " + sandB);

        } else if (degree == 0 && sandB != 0) {
            sandB = 0;

            for (sandA = 5000; sandA > 0; sandA -= 1000, sandB += 1000) {
                System.out.println("SandA = " + sandA + " SandB = " + sandB);
                sleep(1000);
            }
            System.out.println("SandA = " + sandA + " SandB = " + sandB);
        } else if (degree == 90) {
            System.out.println("SandA = " + sandA + " SandB = " + sandB);
        } else if (degree == 180) {
            for (sandA = 0; sandB > 0; sandA += 1000, sandB -= 1000) {
                System.out.println("SandA = " + sandA + " SandB = " + sandB);
                sleep(1000);
            }
            System.out.println("SandA = " + sandA + " SandB = " + sandB);
        } else if (degree == 270) {
            System.out.println("SandA = " + sandA + " SandB = " + sandB);
        } else if (degree == 360) {
            for (sandA = 5000; sandA >= 0; sandA -= 1000, sandB += 1000) {
                System.out.println("SandA = " + sandA + " SandB = " + sandB);
                sleep(1000);
            }
            System.out.println("SandA = " + sandA + " SandB = " + sandB);
        } else {
            System.out.print("Error!!!");
        }
    }

    // เพิ่มเมทอด sleep เพื่อทำการหน่วงเวลา
    private void sleep(long milliseconds) {
        try {
            Thread.sleep(milliseconds);
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
    }
}
