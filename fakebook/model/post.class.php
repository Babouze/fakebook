<?php

/** 
 * @Entity
 * @Table(name="fredouil.post")
 */
class post {

	/** @Id @Column(type="integer")
	 *  @GeneratedValue
	 */ 
	public $id;

	/** @Column(type="text") */ 
	public $texte;
		
	/** @Column(type="datetime") */ 
	public $date;

	/** @Column(type="string", length=45, nullable=true) */ 
	public $pass;
}

?>
