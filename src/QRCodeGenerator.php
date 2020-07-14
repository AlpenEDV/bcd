<?php

/**
 * BCD -Payment Qr Code Generation
 *
 * @copyright (c) AlpenEDV
 * @author Eduard Duanreanu <eduard@alpenedv.at>
 */

namespace Alpenedv\Tools\Bcd;

/**
 * Generates a qr code from the string from the Bill to string Converter Class
 * @author eduard
 */
class QRCodeGenerator
{
    public function generate(string $billmessage, $pdf)
    {
        $style = [
            'border' => 2,
            'vpadding' => 4,
            'hpadding' => 4,
            'fgcolor' => [0, 0, 0],
            'bgcolor' => false,
            'module_width' => 2.16, // width of a single module in points
            'module_height' => 2.16 // height of a single module in points
        ];
        $pdf->write2DBarcode($billmessage, 'QRCODE,M', 150, 50, 40, 40, $style, 'N');

        return $pdf;
    }
}
