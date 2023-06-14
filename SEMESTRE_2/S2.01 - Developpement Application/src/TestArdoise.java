
import ardoise.*;


public class TestArdoise{

    public static void main(String[] args) throws InterruptedException {



        Ardoise ardoise = new Ardoise();



        /*

        INSTANCE POINT

         */


        //Oiseau

        PointPlan p1 = new PointPlan(118,13);
        PointPlan p2 = new PointPlan(123,20);
        PointPlan p3 = new PointPlan(128,13);



        Forme oiseau1 = new Chapeau("oiseau 1", p1, p2, p3);






        PointPlan p4 = new PointPlan(133,30);
        PointPlan p5 = new PointPlan(136,32);
        PointPlan p6 = new PointPlan(138,30);

        Forme oiseau2 = new Chapeau("oiseau 2", p4, p5, p6);








        PointPlan p7 = new PointPlan(142,14);
        PointPlan p8 = new PointPlan(144,17);
        PointPlan p9 = new PointPlan(146,14);

        Forme oiseau3 = new Chapeau("oiseau 3", p7, p8, p9);









        /*
         * Tour
         */
        PointPlan p10 = new PointPlan(9,100);
        PointPlan p11 = new PointPlan(20,100);
        PointPlan p12 = new PointPlan(20,198);
        PointPlan p13 = new PointPlan(9,198);

        Forme Tour = new Quadrilatères("Tour",p10,p11,p12,p13);





        /*
         * Maison
         */
        PointPlan p14 = new PointPlan(80,140);
        PointPlan p15 = new PointPlan(180,140);
        PointPlan p16 = new PointPlan(180,198);
        PointPlan p17 = new PointPlan(80,198);

        Forme CorpMaison = new Quadrilatères("CorpMaison",p14,p15,p16,p17);




        /*
         * Toit
         */
        PointPlan p18 = new PointPlan(80,140);
        PointPlan p19 = new PointPlan(130,100);
        PointPlan p20 = new PointPlan(180,140);


        Forme Toit = new Chapeau("CorpMaison",p18,p19,p20);




        /*
         * Porte maison
         */
        PointPlan p21 = new PointPlan(120,170);
        PointPlan p22 = new PointPlan(140,170);
        PointPlan p23 = new PointPlan(140,198);
        PointPlan p24 = new PointPlan(120,198);

        Forme PorteMaison = new Quadrilatères("PorteMaison",p21,p22,p23,p24);




        /*
         *
         * GF
         *
         */
        GF maison = new GF("Maison",(Quadrilatères)CorpMaison,(Quadrilatères)PorteMaison,(Chapeau)Toit);


        /*
         * Etoile
         */

        //Branche 1

        PointPlan p25 = new PointPlan(170,52);
        PointPlan p26 = new PointPlan(173,45);
        PointPlan p27 = new PointPlan(177,52);

        Forme Branche1 = new Chapeau("Branche1",p25,p26,p27);


        //Branche 2


        PointPlan p28 = new PointPlan(177,52);
        PointPlan p29 = new PointPlan(184,57);
        PointPlan p30 = new PointPlan(177,60);

        Forme Branche2 = new Chapeau("Branche2", p28,p29,p30);


        //Branche 3

        PointPlan p31 = new PointPlan(177,60);
        PointPlan p32 = new PointPlan(174,66);
        PointPlan p33 = new PointPlan(170,60);


        Forme Branche3 = new Chapeau("Branch3",p31,p32,p33);



        //Branche 4

        PointPlan p34 = new PointPlan(170,60);
        PointPlan p35 = new PointPlan(164,57);
        PointPlan p36 = new PointPlan(170,52);

        Forme Branche4 = new Chapeau("Branch4",p34,p35,p36);




        /*
         * Montagne
         */

        //Montage 1

        PointPlan p37 = new PointPlan(3,14);
        PointPlan p38 = new PointPlan(43,3);
        PointPlan p39 = new PointPlan(112,14);


        Forme Montagne1 = new Triangles("Montagne1",p37,p38,p39);


        //Montagne 2

        PointPlan p40 = new PointPlan(152,7);
        PointPlan p41 = new PointPlan(166,3);
        PointPlan p42 = new PointPlan(172,7);

        Forme Montagne2 = new Triangles("Montagne2",p40,p41,p42);





        /*
        Ajout des formes
         */

        //OISEAUX
        ardoise.ajouterForme(oiseau1);
        ardoise.ajouterForme(oiseau2);
        ardoise.ajouterForme(oiseau3);


        //TOUR
        ardoise.ajouterForme(Tour);


        //MAISON
        ardoise.ajouterForme(maison);


        //ETOILES
        ardoise.ajouterForme(Branche1);
        ardoise.ajouterForme(Branche2);
        ardoise.ajouterForme(Branche3);
        ardoise.ajouterForme(Branche4);

        //MONTAGNE
        ardoise.ajouterForme(Montagne1);
        ardoise.ajouterForme(Montagne2);




        ardoise.dessinerGraphique();


        /*
        DEPLACEMENT
         */


       


              for (int step = 0; step < 10 ; step++) {
            synchronized (ardoise) {
               ardoise.wait(150);
            }
            
           
            
           
            ardoise.deplacer("",0,0);
            
         	oiseau1.deplacer(1, 2);
            oiseau2.deplacer(1, 2);
            oiseau3.deplacer(1, 2);
          

            synchronized (ardoise) {
               ardoise.notifyAll();
           
        }
     }
      
    }

    }

}
