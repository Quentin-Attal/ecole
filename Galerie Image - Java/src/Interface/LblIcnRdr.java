package Interface;

import java.awt.Component;

import javax.swing.JLabel;
import javax.swing.JTable;
import javax.swing.table.DefaultTableCellRenderer;

public class LblIcnRdr extends DefaultTableCellRenderer {

	private static final long serialVersionUID = 1L;

	public LblIcnRdr() {
        setHorizontalTextPosition(JLabel.CENTER);
        setVerticalTextPosition(JLabel.BOTTOM);
    }

    @Override
    public Component getTableCellRendererComponent(JTable Jt, Object
        vl, boolean isSelected, boolean focused, int row, int col) {
        JLabel OurJlbl = (JLabel) super.getTableCellRendererComponent(
            Jt, vl, isSelected, focused, row, col);
        setIcon(((LabelIcn) vl).OurIcn);
        setText(((LabelIcn) vl).OurStr);
        return OurJlbl;
    }
}