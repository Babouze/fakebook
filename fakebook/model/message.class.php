<?php

/** 
 * @Entity
 * @Table(name="fredouil.message")
 */
class message {

	/** @Id 
	 *  @Column(type="integer")
	 *  @GeneratedValue
	 */ 
	public $id;

	/**
	* @OneToOne(targetEntity="utilisateur")
	* @JoinColumn(name="emetteur", referencedColumnName="id")
	*/
	public $emetteur;
		
	/**
	* @OneToOne(targetEntity="utilisateur")
	* @JoinColumn(name="destinataire", referencedColumnName="id", nullable=true)
	*/
	public $destinataire;

	/**
	* @OneToOne(targetEntity="utilisateur")
	* @JoinColumn(name="parent", referencedColumnName="id")
	*/
	public $parent;

	/**
	* @OneToOne(targetEntity="post")
	* @JoinColumn(name="post", referencedColumnName="id")
	*/
	public $post;

	/** 
	* @Column(type="integer") 
	*/ 
	public $aime;
	
}

?>
