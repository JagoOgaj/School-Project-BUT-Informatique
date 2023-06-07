import java.util.ArrayList;

import ardoise.*;



public class Triangles extends Forme {
	
	
	
	private PointPlan p1;
	private PointPlan p2;
	private PointPlan p3;
	
	
	public Triangles(String name, PointPlan p1, PointPlan p2, PointPlan p3) {
		
		super(name);
		
		if(name == null) {
			 throw new IllegalArgumentException("Le nom de la forme ne peut pas être nul.");
		}
		
		if (p1 == null || p2 == null || p3 == null) {
			throw new IllegalArgumentException("Les points de la forme ne doivent pas être null");
		}
		
		
		
		if (!(p1 instanceof PointPlan) || !(p2 instanceof PointPlan) || !(p3 instanceof PointPlan)) {
			 throw new IllegalArgumentException("Les points doivent être des points du plan");
		}
		
		this.p1 = p1;
		this.p2 = p2;
		this.p3 = p3;
		
		
		
	}

	@Override
	public void deplacer(int x, int y) {
		// TODO Auto-generated method stub
		
		if (Integer.valueOf(x).getClass().getName().equals(Integer.class.getName()) &&
			    Integer.valueOf(y).getClass().getName().equals(Integer.class.getName())) {
			   
			    p1.setAbscisse(p1.getAbscisse()+x);
			    p1.setOrdonnee(p1.getOrdonnee()+y);

			    p2.setAbscisse(p2.getAbscisse()+x);
			    p2.setOrdonnee(p2.getOrdonnee()+y);

			    p3.setAbscisse(p3.getAbscisse()+x);
			    p3.setOrdonnee(p3.getOrdonnee()+y);

			  
			} else {
			    throw new IllegalArgumentException("Au moins l'une des variables n'est pas un entier");
			}
		
		}
		

	

	@Override
	public ArrayList<Segment> dessiner() {
		// TODO Auto-generated method stub
		ArrayList<Segment> seg = new ArrayList<Segment>();
		
		if (p1 == null || p2 == null || p3 == null) {
			throw new IllegalArgumentException("Les points de la forme ne doivent pas être null");
	}
		
		if (!(p1 instanceof PointPlan) || !(p2 instanceof PointPlan) || !(p3 instanceof PointPlan)) {
			throw new IllegalArgumentException("Les points doivent être des points du plan");
	}
		
		seg.add(new Segment(p1,p2));
		seg.add(new Segment(p1,p3));
		seg.add(new Segment(p2,p3));
		
		
		return seg;
	}

	@Override
	public String typeForme() {
		// TODO Auto-generated method stub
		return "T";
	}

}
