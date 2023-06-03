import java.util.ArrayList;

import ardoise.*;

public class GF extends Forme {
	
	
	private Quadrilatères CorpMaison;
	private Quadrilatères Porte;
	private Chapeau Toit;
	
	
	public GF(String name, Quadrilatères CorpMaison,Quadrilatères Porte, Chapeau Toit) {
		
		super(name);
		
		if (name == null) {
	        throw new IllegalArgumentException("Le nom de la forme ne peut pas être nul.");
	    }
		

		if (CorpMaison == null || Porte == null || Toit== null ) {
			throw new IllegalArgumentException("Les points de la forme ne doivent pas être null");
		}
		
		if (!(CorpMaison instanceof Quadrilatères) || !( Porte instanceof Quadrilatères)|| !( Toit instanceof Chapeau)) {
			throw new IllegalArgumentException("Les points de la forme ne doivent pas être null");
		}
		
		this.CorpMaison = CorpMaison;
		this.Porte = Porte;
		this.Toit = Toit;
		
		
		
		
		
	}
	

	@Override
	public void deplacer(int x, int y) {
		// TODO Auto-generated method stub
		
		if (Integer.valueOf(x).getClass().getName().equals(Integer.class.getName()) &&
			    Integer.valueOf(y).getClass().getName().equals(Integer.class.getName())) {
				
			
			
				CorpMaison.deplacer(x, y);
				Porte.deplacer(x, y);
				Toit.deplacer(x, y);
			
			} else {
			    throw new IllegalArgumentException("Au moins l'une des variables n'est pas un entier");
			}
		
	
	}

	@Override
	public ArrayList<Segment> dessiner() {
		// TODO Auto-generated method stub
		ArrayList<Segment> seg = new ArrayList<Segment>();
		
		seg.addAll(CorpMaison.dessiner());
		seg.addAll(Porte.dessiner());
		seg.addAll(Toit.dessiner());
		
		
		
		return seg;
	}

	@Override
	public String typeForme() {
		// TODO Auto-generated method stub
		return "GF";
	}

}
