<?php
$mysqli = new mysqli("localhost","root","", "proje");
if (mysqli_connect_errno())
{
	printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = "SELECT DISTINCT G.hgnc_sym, V.variant_name, P.pdb_id, P.uniprot_id, F.go_id, F.inter_pro, B.chembl, B.drugbank, E.log_fc FROM genes AS G, variations AS V, proteins AS P, function AS F, bioactivity AS B, expression AS E  WHERE G.hgnc_sym= ?  AND G.ensembl_gene_id=P.ensembl_gene_id AND G.ensembl_gene_id=V.ensembl_gene_id AND P.uniprot_id=F.uniprot_id AND B.uniprot_id=P.uniprot_id AND G.hgnc_sym=E.gene_symbol ";
$stmt = $mysqli->prepare($query);

if(isset($_POST["name"])){
 echo "<h2>For gene symbol: ". $_POST["name"]."</h2>\n";
 echo "<table border=5>";
 echo "<tr><th>"."GENE SYMBOL"."</th><th>"."VARIATION NAME"."</th><th>"."PDB ID"."</th><th>"."UNIPROT ID"."</th><th>"."GO ID"."</th><th>"."INTERPRO"."</th><th>"."ChEMBL"."</th><th>"."DrugBank"."</th><th>"."log FC"."</th></tr>";
 $stmt->bind_param("s", $_POST["name"]);
 
 $stmt->execute();
 
 $result = $stmt->get_result();
 while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
	 echo "<tr><td>".$row['hgnc_sym']."</td><td>".$row['variant_name']."</td><td>".$row['pdb_id']."</td><td>".$row['uniprot_id']."</td><td>".$row['go_id']."</td><td>".$row['inter_pro']."</td><td>".$row['chembl']."</td><td>".$row['drugbank']."</td><td>".$row['log_fc']."</td></tr>";
 } 
 echo "</table>";
}

$mysqli->close();
?>
 