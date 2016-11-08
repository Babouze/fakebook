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
	* @ManyToOne(targetEntity="utilisateur")
	* @JoinColumn(name="emetteur", referencedColumnName="id")
	*/
	public $emetteur;
		
	/**
	* @ManyToOne(targetEntity="utilisateur")
	* @JoinColumn(name="destinataire", referencedColumnName="id", nullable=true)
	*/
	public $destinataire;

	/**
	* @ManyToOne(targetEntity="utilisateur")
	* @JoinColumn(name="parent", referencedColumnName="id")
	*/
	public $parent;

	/**
	* @ManyToOne(targetEntity="post")
	* @JoinColumn(name="post", referencedColumnName="id")
	*/
	public $post;

	/** 
	* @Column(type="integer") 
	*/ 
	public $aime;
	
}

?>
