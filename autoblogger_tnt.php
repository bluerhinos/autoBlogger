<?php


function proc_tnt($filen, &$post){

	$filename = basename($filen);

	$pos = 0;
	$file = file_get_contents($filen);
	
	$info['tagversion'] = readline($file,$pos,8);
	$info['TMAGtag'] = readline($file,$pos,4);
	$info['TMAGbool'] = readline($file,$pos,4,"int");
	$info['TECMAGlen'] = readline($file,$pos,4,"int");
	$infod['TECMAGstruct'] = readline($file,$pos,$info['TECMAGlen'],"str");
	
		$pos_t = 0;
		for($i=1;$i<=4;$i++)
			$info['TECMAG']['ntps'][$i] = readline($infod['TECMAGstruct'],$pos_t,4,"long");
		for($i=1;$i<=4;$i++)
			$info['TECMAG']['actual_ntps'][$i] = readline($infod['TECMAGstruct'],$pos_t,4,"long");
		$info['TECMAG']['acq_ntps'] = readline($infod['TECMAGstruct'],$pos_t,4,"long");
		for($i=1;$i<=4;$i++)
			$info['TECMAG']['ntps_start'][$i] = readline($infod['TECMAGstruct'],$pos_t,4,"long");
		$info['TECMAG']['scans'] = readline($infod['TECMAGstruct'],$pos_t,4,"long");
		$info['TECMAG']['actual_scans'] = readline($infod['TECMAGstruct'],$pos_t,4,"long");
		$info['TECMAG']['dummy_scans'] = readline($infod['TECMAGstruct'],$pos_t,4,"long");
		$info['TECMAG']['repeat_times'] = readline($infod['TECMAGstruct'],$pos_t,4,"long");
		$info['TECMAG']['sadminension'] = readline($infod['TECMAGstruct'],$pos_t,4,"long");
		$info['TECMAG']['samode'] = readline($infod['TECMAGstruct'],$pos_t,4,"long");
	
		
		$info['TECMAG']['magnetic_field'] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		for($i=1;$i<=4;$i++)
			$info['TECMAG']['ob_freq'][$i] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		for($i=1;$i<=4;$i++)
			$info['TECMAG']['base_fq'][$i] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		for($i=1;$i<=4;$i++)
			$info['TECMAG']['offset_fq'][$i] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		$info['TECMAG']['ref_freq'] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		$info['TECMAG']['NMR_frequency'] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		$info['TECMAG']['obs_channel'] = readline($infod['TECMAGstruct'],$pos_t,2,"short");
		
		$conf['blackingchr'] = readline($infod['TECMAGstruct'],$pos_t,1,"str");
		$pos_t += 41;

		
		for($i=1;$i<=4;$i++)
			$info['TECMAG']['sw'][$i] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		for($i=1;$i<=4;$i++)
			$info['TECMAG']['dwell'][$i] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		$info['TECMAG']['filter'] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		$info['TECMAG']['experiment_time'] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		$info['TECMAG']['acq_time'] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		$info['TECMAG']['last_delay'] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		
		
		$info['TECMAG']['spectrum_direction'] = readline($infod['TECMAGstruct'],$pos_t,2,"short");
		$info['TECMAG']['hardware_sideband'] = readline($infod['TECMAGstruct'],$pos_t,2,"short");
		$info['TECMAG']['taps'] = readline($infod['TECMAGstruct'],$pos_t,2,"short");
		$info['TECMAG']['type'] = readline($infod['TECMAGstruct'],$pos_t,2,"short");
		$info['TECMAG']['bDigRec'] = readline($infod['TECMAGstruct'],$pos_t,4,"int");		
		$info['TECMAG']['nDigitalCenter'] = readline($infod['TECMAGstruct'],$pos_t,4,"long");
		$pos_t += 16;
		
		$info['TECMAG']['transmitter_gain'] = readline($infod['TECMAGstruct'],$pos_t,2,"short");
		$info['TECMAG']['receiver_gain'] = readline($infod['TECMAGstruct'],$pos_t,2,"short");
		$info['TECMAG']['NumberOfReceivers'] = readline($infod['TECMAGstruct'],$pos_t,2,"short");
		$info['TECMAG']['RG2'] = readline($infod['TECMAGstruct'],$pos_t,2,"short");
		$info['TECMAG']['receiver_phase'] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		$pos_t += 4;
		
		$info['TECMAG']['set_spin_rate'] = readline($infod['TECMAGstruct'],$pos_t,2,"ushort");
		$info['TECMAG']['actual_spin_rate'] = readline($infod['TECMAGstruct'],$pos_t,2,"ushort");
		
		$info['TECMAG']['lock_field'] = readline($infod['TECMAGstruct'],$pos_t,2,"short");
		$info['TECMAG']['lock_power'] = readline($infod['TECMAGstruct'],$pos_t,2,"short");
		$info['TECMAG']['lock_gain'] = readline($infod['TECMAGstruct'],$pos_t,2,"short");
		$info['TECMAG']['lock_phase'] = readline($infod['TECMAGstruct'],$pos_t,2,"short");
		$info['TECMAG']['lock_freq_mhz'] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		$info['TECMAG']['lock_ppm'] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		$info['TECMAG']['H20_freq_ref'] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		$pos_t += 16;
		$info['TECMAG']['set_temperature'] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		$info['TECMAG']['actual_temperature'] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		
		$info['TECMAG']['shim_units'] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		for($i=1;$i<=36;$i++)
			$info['TECMAG']['shims'][$i] = readline($infod['TECMAGstruct'],$pos_t,2,"short");
		
		$info['TECMAG']['shim_FWHM'] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		
		
		$info['TECMAG']['HH_dcpl_attn'] = readline($infod['TECMAGstruct'],$pos_t,2,"short");
		$info['TECMAG']['DF_DN'] = readline($infod['TECMAGstruct'],$pos_t,2,"short");
		for($i=1;$i<=7;$i++)
			$info['TECMAG']['F1_tran_mode'][$i] = readline($infod['TECMAGstruct'],$pos_t,2,"short");
		$info['TECMAG']['dec_DW'] = readline($infod['TECMAGstruct'],$pos_t,2,"short");
		
		$info['TECMAG']['grd_orientation'] = readline($infod['TECMAGstruct'],$pos_t,4,"str+");	
		$info['TECMAG']['LatchLP'] = readline($infod['TECMAGstruct'],$pos_t,4,"long");
		$info['TECMAG']['grd_Theta'] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		$info['TECMAG']['grd_Phi'] = readline($infod['TECMAGstruct'],$pos_t,8,"double");
		$pos_t += 264;
		
		$info['TECMAG']['start_time'] = readline($infod['TECMAGstruct'],$pos_t,4,"long");
		$info['TECMAG']['finish_time'] =readline($infod['TECMAGstruct'],$pos_t,4,"long");
		$info['TECMAG']['elapsed_time'] = readline($infod['TECMAGstruct'],$pos_t,4,"long");	
		
		$info['TECMAG']['date'] = readline($infod['TECMAGstruct'],$pos_t,32,"str+");
		$info['TECMAG']['nucleus_1D'] = readline($infod['TECMAGstruct'],$pos_t,16,"str+");
		$info['TECMAG']['nucleus_2D'] = readline($infod['TECMAGstruct'],$pos_t,16,"str+");
		$info['TECMAG']['nucleus_3D'] = readline($infod['TECMAGstruct'],$pos_t,16,"str+");
		$info['TECMAG']['nucleus_4D'] = readline($infod['TECMAGstruct'],$pos_t,16,"str+");
		$info['TECMAG']['sequence'] = readline($infod['TECMAGstruct'],$pos_t,32,"str+");
		$info['TECMAG']['lock_solvent'] = readline($infod['TECMAGstruct'],$pos_t,16,"str+");
		$info['TECMAG']['lock_nucleus'] = readline($infod['TECMAGstruct'],$pos_t,16,"str+");
		
	
		
	$info['DATAtag'] = readline($file,$pos,4);
	$info['DATAbool'] = readline($file,$pos,4,"int");
	$info['DATAlen'] = readline($file,$pos,4,"int");
	$infod['DATAstruct'] = readline($file,$pos,	$info['DATAlen']);
	/*
	$pos_t = 0;
	foreach($info['TECMAG']['actual_ntps'] as $k=>$v){
		if($v>1){
			for($i=1;$i<=$v;$i++){
				$info['DATA'][$k][$i]['r'] = readline($infod['DATAstruct'],$pos_t,4,"float");
				$info['DATA'][$k][$i]['i'] = readline($infod['DATAstruct'],$pos_t,4,"float");
			}
		}
	}
	*/
	
	$info['TMG2tag'] = readline($file,$pos,4);
	$info['TMG2bool'] = readline($file,$pos,4,"int");
	$info['TMG2len'] = readline($file,$pos,4,"int");
	$infod['TMG2struct'] = readline($file,$pos,$info['TMG2len']);
		$pos_t = 0;
		$info['TECMAG2']['real_flag'] = readline($infod['TMG2struct'],$pos_t,4,"int");
		$info['TECMAG2']['imag_flag'] = readline($infod['TMG2struct'],$pos_t,4,"int");
		$info['TECMAG2']['magn_flag'] = readline($infod['TMG2struct'],$pos_t,4,"int");
		$info['TECMAG2']['axis_vis'] = readline($infod['TMG2struct'],$pos_t,4,"int");
		$info['TECMAG2']['auto_scale'] = readline($infod['TMG2struct'],$pos_t,4,"int");
		$info['TECMAG2']['line_display'] = readline($infod['TMG2struct'],$pos_t,4,"int");
		$info['TECMAG2']['show_shim_units'] = readline($infod['TMG2struct'],$pos_t,4,"int");
		
		$info['TECMAG2']['integral_display'] = readline($infod['TMG2struct'],$pos_t,4,"int");
		$info['TECMAG2']['fit_display'] = readline($infod['TMG2struct'],$pos_t,4,"int");
		$info['TECMAG2']['show_pivot'] = readline($infod['TMG2struct'],$pos_t,4,"int");
		$info['TECMAG2']['label_peaks'] = readline($infod['TMG2struct'],$pos_t,4,"int");
		$info['TECMAG2']['keep_manual_peaks'] = readline($infod['TMG2struct'],$pos_t,4,"int");
		$info['TECMAG2']['label_peaks_in_units'] = readline($infod['TMG2struct'],$pos_t,4,"int");
		$info['TECMAG2']['integral_dc_average'] = readline($infod['TMG2struct'],$pos_t,4,"int");
		$info['TECMAG2']['integral_show_multiplier'] = readline($infod['TMG2struct'],$pos_t,4,"int");
		$pos_t += 36;
		
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['all_ffts_done'][$i] = readline($infod['TMG2struct'],$pos_t,4,"int");
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['all_phase_done'][$i] = readline($infod['TMG2struct'],$pos_t,4,"int");
		
		$info['TECMAG2']['amp'] = readline($infod['TMG2struct'],$pos_t,8,"double");
		$info['TECMAG2']['ampbits'] = readline($infod['TMG2struct'],$pos_t,8,"double");
		$info['TECMAG2']['ampCtl'] = readline($infod['TMG2struct'],$pos_t,8,"double");
		$info['TECMAG2']['offset'] = readline($infod['TMG2struct'],$pos_t,4,"long");
	
		
		$info['TECMAG2']['axis_set'] = readline($infod['TMG2struct'],$pos_t,256,"str+");
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['display_units'][$i] = readline($infod['TMG2struct'],$pos_t,2,"short");
		for($i=1;$i<=4;$i++)
				$info['TECMAG2']['ref_point'][$i] = readline($infod['TMG2struct'],$pos_t,4,"long");
		for($i=1;$i<=4;$i++)
				$info['TECMAG2']['ref_value'][$i] = readline($infod['TMG2struct'],$pos_t,8,"double");
		$info['TECMAG2']['z_start'] = readline($infod['TMG2struct'],$pos_t,4,"long");	
		$info['TECMAG2']['z_end'] = readline($infod['TMG2struct'],$pos_t,4,"long");	
		$info['TECMAG2']['z_select_start'] = readline($infod['TMG2struct'],$pos_t,4,"long");	
		$info['TECMAG2']['z_select_end'] = readline($infod['TMG2struct'],$pos_t,4,"long");
		$info['TECMAG2']['last_zoom_start'] = readline($infod['TMG2struct'],$pos_t,4,"long");	
		$info['TECMAG2']['last_zoom_end'] = readline($infod['TMG2struct'],$pos_t,4,"long");
		$info['TECMAG2']['index_2D'] = readline($infod['TMG2struct'],$pos_t,4,"long");
		$info['TECMAG2']['index_3D'] = readline($infod['TMG2struct'],$pos_t,4,"long");
		$info['TECMAG2']['index_4D'] = readline($infod['TMG2struct'],$pos_t,4,"long");
	
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['apodization_done'][$i] = readline($infod['TMG2struct'],$pos_t,4,"long");
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['linebrd'][$i] = readline($infod['TMG2struct'],$pos_t,8,"double");
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['gaussbrd'][$i] = readline($infod['TMG2struct'],$pos_t,8,"double");
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['dmbrd'][$i] = readline($infod['TMG2struct'],$pos_t,8,"double");
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['sine_bell_shift'][$i] = readline($infod['TMG2struct'],$pos_t,8,"double");
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['sine_bell_width'][$i] = readline($infod['TMG2struct'],$pos_t,8,"double");
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['sine_bell_skew'][$i] = readline($infod['TMG2struct'],$pos_t,8,"double");
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['Trapz_point_1'][$i] = readline($infod['TMG2struct'],$pos_t,4,"long");
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['Trapz_point_2'][$i] = readline($infod['TMG2struct'],$pos_t,4,"long");
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['Trapz_point_3'][$i] = readline($infod['TMG2struct'],$pos_t,4,"long");
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['Trapz_point_4'][$i] = readline($infod['TMG2struct'],$pos_t,4,"long");
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['trafbrd'][$i] = readline($infod['TMG2struct'],$pos_t,8,"double");
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['echo_center'][$i] = readline($infod['TMG2struct'],$pos_t,4,"long");
	
		$info['TECMAG2']['data_shift_points'] = readline($infod['TMG2struct'],$pos_t,4,"long");
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['fft_flag'][$i] = readline($infod['TMG2struct'],$pos_t,2,"short");
		$pos_t += 64;
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['pivot_point'][$i] = readline($infod['TMG2struct'],$pos_t,4,"long");
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['cumm_0_phase'][$i] = readline($infod['TMG2struct'],$pos_t,8,"double");
		for($i=1;$i<=4;$i++)
			$info['TECMAG2']['cumm_1_phase'][$i] = readline($infod['TMG2struct'],$pos_t,8,"double");
		$info['TECMAG2']['manual_0_phase'] = readline($infod['TMG2struct'],$pos_t,8,"double");
		$info['TECMAG2']['manual_1_phase'] = readline($infod['TMG2struct'],$pos_t,8,"double");
		$info['TECMAG2']['phase_0_value'] = readline($infod['TMG2struct'],$pos_t,8,"double");
		$info['TECMAG2']['phase_1_value'] = readline($infod['TMG2struct'],$pos_t,8,"double");
		$info['TECMAG2']['session_phase_0'] = readline($infod['TMG2struct'],$pos_t,8,"double");
		$info['TECMAG2']['session_phase_1'] = readline($infod['TMG2struct'],$pos_t,8,"double");
		
		$info['TECMAG2']['max_index'] = readline($infod['TMG2struct'],$pos_t,4,"long");
		$info['TECMAG2']['min_index'] = readline($infod['TMG2struct'],$pos_t,4,"long");
		$info['TECMAG2']['peak_threshold'] = readline($infod['TMG2struct'],$pos_t,4,"float");
		$info['TECMAG2']['peak_noise'] = readline($infod['TMG2struct'],$pos_t,4,"float");
		$info['TECMAG2']['integral_dc_points'] = readline($infod['TMG2struct'],$pos_t,2,"short");
		$info['TECMAG2']['integral_label_type'] = readline($infod['TMG2struct'],$pos_t,2,"short");
		$info['TECMAG2']['integral_sacle_factor'] = readline($infod['TMG2struct'],$pos_t,4,"float");
		$info['TECMAG2']['auto_integrate_sholder'] = readline($infod['TMG2struct'],$pos_t,4,"long");
		$info['TECMAG2']['auto_integrate_noise'] = readline($infod['TMG2struct'],$pos_t,8,"double");
		$info['TECMAG2']['auto_integrate_threshold'] = readline($infod['TMG2struct'],$pos_t,8,"double");
		$info['TECMAG2']['s_n_peak'] = readline($infod['TMG2struct'],$pos_t,4,"long");
		$info['TECMAG2']['s_n_noise_start'] = readline($infod['TMG2struct'],$pos_t,4,"long");
		$info['TECMAG2']['s_n_noise_end'] = readline($infod['TMG2struct'],$pos_t,4,"long");
		$info['TECMAG2']['s_n_calculated'] = readline($infod['TMG2struct'],$pos_t,4,"float");
		for($i=1;$i<=14;$i++)
			$info['TECMAG2']['Spline_point'][$i] = readline($infod['TMG2struct'],$pos_t,4,"long");
		$info['TECMAG2']['Spline_point_avg'] = readline($infod['TMG2struct'],$pos_t,2,"short");
		for($i=1;$i<=8;$i++)
			$info['TECMAG2']['Poly_point'][$i] = readline($infod['TMG2struct'],$pos_t,4,"long");
		$info['TECMAG2']['Poly_point_avg'] = readline($infod['TMG2struct'],$pos_t,2,"short");
		$info['TECMAG2']['Poly_order'] = readline($infod['TMG2struct'],$pos_t,2,"short");
		
		$pos_t += 610;
		$info['TECMAG2']['line_simulation_name'] = readline($infod['TMG2struct'],$pos_t,32,"str+");
		$info['TECMAG2']['integral_template_name'] = readline($infod['TMG2struct'],$pos_t,32,"str+");
		$info['TECMAG2']['baseline_template_name'] = readline($infod['TMG2struct'],$pos_t,32,"str+");
		$info['TECMAG2']['layout_name'] = readline($infod['TMG2struct'],$pos_t,32,"str+");
		$info['TECMAG2']['relax_information_name'] = readline($infod['TMG2struct'],$pos_t,32,"str+");
		$info['TECMAG2']['username'] = readline($infod['TMG2struct'],$pos_t,32,"str+");
		$info['TECMAG2']['user_string_1'] = readline($infod['TMG2struct'],$pos_t,16,"str+");
		$info['TECMAG2']['user_string_2'] = readline($infod['TMG2struct'],$pos_t,16,"str+");
		$info['TECMAG2']['user_string_3'] = readline($infod['TMG2struct'],$pos_t,16,"str+");
		$info['TECMAG2']['user_string_4'] = readline($infod['TMG2struct'],$pos_t,16,"str+");

//	$info['PSEQtag'] = readline($file,$pos,4);
//	$info['PSEQbool'] = readline($file,$pos,4,"int");
//	$info['PSEQstruct'] = readline($file,$pos,10,"str");
	$post['title'] = str_replace("_"," ",substr($filename,0, strripos($filename,".")));
	$post['datetime'] = $info['TECMAG']['finish_time'];
	foreach(array(4=>"4D",3=>"3D",2=>"2D",1=>"1D") as $i=>$j)
		if($info['TECMAG']['ntps'][$i]>1){
			$tmp['type'] = $j;
			$tmp['dims'] = $i;
			break;
		}
	$t=NULL; $s=NULL;
	for($i=1;$i<=$tmp['dims'];$i++){
		$t[] = $info['TECMAG']['ntps'][$i];
		$s[] = $info['TECMAG']['actual_ntps'][$i];
	}	
	$tmp['scans'] = join(",",$t)."/".join(",",$s);

	$t=NULL; $s=NULL;	
	for($i=1;$i<=$tmp['dims'];$i++){
		$t[] = $info['TECMAG']['sw'][$i];
		$s[] = $info['TECMAG']['dwell'][$i];
	}
		$tmp['sw'] = join(",",$t);
		$tmp['dwell'] = join(",",$s);
	
	$t=NULL; $s=NULL;
	for($i=1;$i<=$tmp['dims'];$i++){
		$t[] = $info['TECMAG']["nucleus_{$i}D"];
	}
	$tmp['nucleus'] = join(",",$t);
	$post['meta']['nucleus'] = join(";",$t);
		
	$post['content'] = <<<END

[table]
		[mrow]Extra Information[/mrow]
		[row]Filter Width[col]{$info['TECMAG']['filter']}[/row]
		[row]No of Scans - requested/actual[col]{$tmp['scans']}[/row]
		[row]No of Dummy Scans[col]{$info['TECMAG']['dummy_scans']}[/row]
		[row]Spectral width (Hz)[col]{$tmp['sw']}[/row]
		[row]Dwell time (s)[col]{$tmp['dwell']}[/row]
		[row]Temperature - requested/actual (K)[col]{$info['TECMAG']['set_temperature']}/{$info['TECMAG']['actual_temperature']}[/row]
		
		
[/table]
END;


$post['meta']['Dimensions'] = $tmp['type'];
$post['meta']['Temperature'] = $info['TECMAG']['set_temperature'];
$post['meta']['Solvent'] = $info['TECMAG']['lock_solvent'];

$post['data'][0] = array("filename"=>$filename,"content"=>$file,"ext"=>"tnt", "title"=>"TNT File: {$filename}");
$post['data'][1] = array("filename"=>"report.txt","content"=>"","ext"=>"txt","title"=>"Report from {$filename}"); 
$post['data'][1]['content'] = "=== TECMAG Data ===\n";
$post['data'][1]['content'] .= var_export($info['TECMAG'],true);
$post['data'][1]['content'] .= "\n\n=== TECMAG2 Data ===\n";
$post['data'][1]['content'] .= var_export($info['TECMAG2'],true);

	return $post;

}

?>