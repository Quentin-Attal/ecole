package Interface;

import javax.imageio.ImageIO;

import javax.swing.*;
import javax.swing.filechooser.FileNameExtensionFilter;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.awt.event.*;
import java.nio.file.*;
import java.awt.*;
import javax.swing.table.*;




public class Fenetre extends JFrame implements ActionListener {
	private static final long serialVersionUID = 1L;
	
	private List<String> Name = new ArrayList<String>();
	private JTable table;
	private JFrame frame = new JFrame();
	private Timer timer  = new Timer(10,this);;
	private boolean RszBool = true;
	private boolean delete = false;
	private boolean renam = false;
	private boolean zm = false;
	
	public void Timer() throws InterruptedException {
		timer.setDelay(timer.getInitialDelay());
		RszBool = true;
		timer.start();
	}
	
	
	public Fenetre(){
		
        UIManager.put("OptionPane.background", Color.white);
        UIManager.put("Panel.background", Color.white);
		frame.setTitle("Pokedex");
		frame.setSize(1000, 1000);
		frame.setMinimumSize(new Dimension(600, 600));
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		frame.setLocationRelativeTo(null);
		this.Affichage();
		frame.addComponentListener(new ComponentListener() {
			public void componentResized(ComponentEvent componentEvent) {
				try {
					Timer();
				} catch (InterruptedException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}				

		    }

			@Override
			public void componentHidden(ComponentEvent arg0) {
				// TODO Auto-generated method stub

			}

			@Override
			public void componentMoved(ComponentEvent e) {
				// TODO Auto-generated method stub

			}

			@Override
			public void componentShown(ComponentEvent e) {
				// TODO Auto-generated method stub
				
			}
		});
	} 
	
	private void ZoomImg(int row, int col)
	{
		
        if (row >= 0 && col >= 0) {
        	//on affiche le nom de l'image et on d?ini l'ic?e ?afficher pour cr?r une popup avec l'image en taille r?lle
        	Object[] possibilities = {"Previous","Close","Next"};
            boolean check = true; 
            int x;
            while(check == true){
            	String pokedesc = "<html><body width='%1s' height='%1s'><h1>"+Name.get(row*5+col).substring(14,Name.get(row*5+col).length() - 4)+"</h1></body></html>";
            	ImageIcon myicn = new ImageIcon(Name.get(row*5+col));
	            Image image = myicn.getImage(); // transform it 
	            Image newimg = image.getScaledInstance(500, 500,  Image.SCALE_SMOOTH);
	            myicn = new ImageIcon(newimg);

	            //d?ini le style de la popup : le fond sera blanc pour un rendu plus propre

	            
            	String name = new String(Name.get(row*5+col).substring(14,Name.get(row*5+col).length() - 4));
            	x = JOptionPane.showOptionDialog(null, pokedesc, name,JOptionPane.DEFAULT_OPTION, JOptionPane.PLAIN_MESSAGE,myicn,possibilities,possibilities[0]);
            	
            	if (x==0) {
		            	col = row*5+col > 0 ? col - 1 : col;
		            }
		            else if(x == 2){
		            	col = row*5+col < Name.size() - 1? col +1 : col;
		            }
		            else {
		            	check = false;
		            }
            }
        }
	}
	
	private void CreateTable() {
		int mot = Name.size();
		if (mot/5*5 < Name.size()) {
			mot +=5;
		}

		Object[][] rows = new Object[mot/5][5];
		for (int i=0;i<mot/5;i++) {
			for (int j = 0; j<5;j++) {
				if (i*5+j >= Name.size()) {
					ImageIcon icon = new ImageIcon("Important/Vide.png");
		            Image image = icon.getImage(); // transform it 
		            Image newimg = image.getScaledInstance(frame.getWidth()/5, frame.getWidth()/5,  Image.SCALE_SMOOTH); // scale it the smooth way  
		            icon = new ImageIcon(newimg);
		            String pokname = "";
					rows[i][j] =  new LabelIcn(icon,pokname);	
					continue;
				}
	            ImageIcon icon = new ImageIcon(Name.get(i*5+j));
	            Image image = icon.getImage(); // transform it 
	            Image newimg = image.getScaledInstance(frame.getWidth()/5, frame.getWidth()/5,  Image.SCALE_SMOOTH); // scale it the smooth way  
	            icon = new ImageIcon(newimg);
	            String pokname = Name.get(i*5+j).substring(14,Name.get(i*5+j).length() - 4);
				rows[i][j] =  new LabelIcn(icon,pokname);				
			}
		}
		String[] columns = {"","","","",""};
		DefaultTableModel model = new DefaultTableModel(rows, columns) {
		    /**
			 * 
			 */
			private static final long serialVersionUID = 1L;

			
			@Override
		    public Class<?> getColumnClass(int column) {
				return LabelIcn.class;
		    }
			public boolean isCellEditable(int row, int column){  
			      return false;  
			}
		};
		table = new JTable(model);
        table.setDefaultRenderer(LabelIcn.class, new LblIcnRdr());
        table.setRowHeight(frame.getWidth()/5 + 20);
        table.addMouseListener((new java.awt.event.MouseAdapter() {
            @Override
            public void mouseClicked(java.awt.event.MouseEvent evt) {
            	if (delete == true) {
            		int row = table.rowAtPoint(evt.getPoint());
                    int col = table.columnAtPoint(evt.getPoint());
                    if (row*5+col < Name.size()) {
                    	Suppr(row, col);
                    }
            		delete = false;
            	}
            	if (renam == true) {
            		int row = table.rowAtPoint(evt.getPoint());
                    int col = table.columnAtPoint(evt.getPoint());
                    if (row*5+col < Name.size()) {
                    	Rename(row, col);
                    }
            		renam = false;
            	}
            	if (zm==true)
            	{
            		int row = table.rowAtPoint(evt.getPoint());
                    int col = table.columnAtPoint(evt.getPoint());
                    if (row*5+col < Name.size()) {
                        ZoomImg(row, col);
                    }
                    zm = false;
            	}
            	if (evt.getClickCount() == 2) {
            		int row = table.rowAtPoint(evt.getPoint());
                    int col = table.columnAtPoint(evt.getPoint());
                    if (row*5+col < Name.size()) {
                        ZoomImg(row, col);
                    }
            	}
                
            }
        }));
        
        table.addKeyListener(new KeyListener() {
            public void keyTyped(KeyEvent ke) { 
                if (ke.getKeyChar() == KeyEvent.VK_DELETE) {
                	zm = renam = false;
                	int row = table.getSelectedColumn();
                    int col = table.getSelectedRow();
                    if (col*5+row < Name.size()) {
                        Suppr(col,row);
                    }
                }
                if (ke.getKeyChar() == 'r') {
                	zm = delete = false;
                	int row = table.getSelectedColumn();
                    int col = table.getSelectedRow();
                    if (col*5+row < Name.size()) {
                        Rename(col,row);
                    }
                }
              }
              public void keyPressed(KeyEvent ke) {}
              public void keyReleased(KeyEvent ke) {}

			
          });
        table.setRowSelectionAllowed(false);
        frame.add(table);
		JScrollPane scrollPane = new JScrollPane(table);
		frame.add(scrollPane);
	}
	private void Suppr(int row, int col) {
		ImageIcon myicn = new ImageIcon(Name.get(row*5+col));
    	Image image = myicn.getImage(); // transform it 
        Image newimg = image.getScaledInstance(200, 200,  Image.SCALE_SMOOTH);
        myicn =  new ImageIcon(newimg);
    	int response = JOptionPane.showConfirmDialog(null, "Are you sure you want to delete this image?", "Delete image",
    	        JOptionPane.YES_NO_OPTION, JOptionPane.QUESTION_MESSAGE, myicn);
    	    if (response == JOptionPane.YES_OPTION) {
    	    	Path imagetodelete = Paths.get(Name.get(row*5+col));
    	    	try {
    	    		Files.delete(imagetodelete);
    	    	}
    	    	catch(Exception e){
    	    	}
    	    	Affichage();
    	    } 
	}
	private void Rename(int row, int col) {
		ImageIcon myicn = new ImageIcon(Name.get(row*5+col));
    	Image image = myicn.getImage(); // transform it 
        Image newimg = image.getScaledInstance(200, 200,  Image.SCALE_SMOOTH);
        myicn =  new ImageIcon(newimg);
        String nom = JOptionPane.showInputDialog(null, "How do you want to rename this image?", "Image Name", JOptionPane.QUESTION_MESSAGE);
        String imagetorename = Name.get(row*5+col);
        File file = new File(imagetorename);
        System.out.println(nom);
        if (nom.isEmpty() || nom == null) {
        	nom = Name.get(row*5+col);
        }
        try {
        	file.renameTo(new File("Image Pokemon/"+nom+".jpg"));
    	}
    	catch(Exception e){
    		
    	}
    	Affichage();
	}
	private void InitName() {
		Name.clear();
		File folder = new File("Image Pokemon");
		for (File Name2 : folder.listFiles()) {
			this.Name.add(Name2.getPath());
		}
	}
	private void Affichage() {
		frame.getContentPane().removeAll();
		this.Menu();
		this.InitName();
		this.CreateTable();		
		frame.setVisible(true);

	}
	
	
	private void Menu() {
		JMenuBar menuBar = new JMenuBar();
		 
		JMenu menu1 = new JMenu("File");
 
		JMenuItem add = new JMenuItem("Add");
		menu1.add(add);
		add.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				JFileChooser chooser = new JFileChooser();		//JFileChooser extension Swing pour aller chercher un fichier dans le PC client
			    FileNameExtensionFilter filter = new FileNameExtensionFilter( 	// Filtre format image uniquement
			        "JPG & PNG Images", "jpg", "png");
			    chooser.setFileFilter(filter);
			    Component parent = null;
				int returnVal = chooser.showOpenDialog(parent);	 //Place dans le dossier documents
			    if(returnVal == JFileChooser.APPROVE_OPTION) {
			       File file = chooser.getSelectedFile(); 	//Retourne le fichier sous forme de chemin absolu avec file
			       File newfile = new File("Image Pokemon/"+file.getName());			       
			       try {
					ImageIO.write(ImageIO.read(file), "png", newfile);
				} catch (IOException e1) {
					// TODO Auto-generated catch block
					e1.printStackTrace();
				}		
			       Affichage();
			    }
			}
		});
		JMenuItem rem = new JMenuItem("Remove");
		rem.addActionListener(new ActionListener() {
		    @Override
		    public void actionPerformed(ActionEvent actionEvent) {
		    	zm = renam = false;
		      delete = !delete;
		    }
		});
		menu1.add(rem);
 
		JMenuItem quitter = new JMenuItem("Exit");
		quitter.addActionListener(new ActionListener() {
		    @Override
		    public void actionPerformed(ActionEvent actionEvent) {
		      System.exit(0);
		    }
		});
		menu1.add(quitter);
 
		menuBar.add(menu1);
		
		JMenu menu3 = new JMenu("Edit");
		 
		JMenuItem edit = new JMenuItem("Rename");
		edit.addActionListener(new ActionListener() {
		    @Override
		    public void actionPerformed(ActionEvent actionEvent) {
		      zm = delete = false;
		      renam = !renam;
		    }
		});
		menu3.add(edit);
 
		menuBar.add(menu3);
 
		 
		frame.setJMenuBar(menuBar);
		JMenu menu4 = new JMenu("View");
		JMenuItem view = new JMenuItem("Zoom");
		view.addActionListener(new ActionListener()
				{
					@Override
					public void actionPerformed(ActionEvent actionevent)
					{
						delete = renam = false;
						zm = !zm;
					}
				});
		menu4.add(view);
 
		menuBar.add(menu4);
 
		frame.setJMenuBar(menuBar);
		JMenu menu2 = new JMenu("Help");
		 
		//boutton faisant apparaitre une popup contenant toute l'aide de l'application mise en page gr?e ?de l'HTML
		JMenuItem aPropos = new JMenuItem("Help Message");
		aPropos.addActionListener(new ActionListener()
				{
				@Override
				public void actionPerformed(ActionEvent actionEvent)
				{
					String Helptext = "<html><body width='%1s' height='%1s'><h1>Help</h1>"
			                + "<p>Welcome to the help section of this Gallery <br> "
			                + "<h2>1.Commands</h2> "
			                + "<h3>File</h3>"
			                + "<h4>Add :</h4>"
			                + "<p>This section lets you add a picture from your computer to this library</p>"
			                + "<h4>Remove</h4>"
			                + "<p>This section allows you to delete any picture in this gallery from your Computer by clicking on it. Be carefull as this process will delete permanently the file <br>"
			                + "You can also delete a picture by clicking on it and then clicking 'del' on your keyboard</p>"
			                + "<h4>Exit :</h4>"
			                + "<p>By clicking exit, you will leave the application</p>"
			                + "<br><br><h3>Edit</h3>"
			                + "<h4>Rename :</h4>"
			                + "<p>This section lets you rename a picture by clicking on it<br>"
			                + "You can also rename pictures by clicking on them and then clicking 'r' key on your keyboard</p>"
			                + "<br><br><h3>View</h3>"
			                + "<h4>Zoom :</h4>"
			                + "<p>This section displays the picture at a bigger size. <br> Once you have opened the picture, you can press 'Previous' and 'Next' to travel trought the gallery</p>"
			                + "<br><br><h3>Resize</h3>"
			                + "<p>You can resize the window's size by dragging its borders</p>"
			                + "<h2>2.About</h2>"
			                + "<p>This project is created by a team of 4 developpers for a JAVA project</p>";
					
					int wdt = 700;

		            JOptionPane.showMessageDialog(null, String.format(Helptext, wdt, wdt));
					
				}
				})
		;
		menu2.add(aPropos);
 
		menuBar.add(menu2);
 
		frame.setJMenuBar(menuBar);
	}
 
	@Override
	public void actionPerformed(ActionEvent e) {
		if (RszBool == true) {
			timer.setDelay(timer.getDelay() - 1);
			if (timer.getDelay() == 0) {
				RszBool = false;
				Affichage();
			}
		}
	}
	
	
	
	


}



