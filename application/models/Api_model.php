<?php

class Api_model extends CI_Model
{

    public function getProducts($lang)
    {
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', $lang);
        $query = $this->db->select('vendors.name as vendor_name, vendors.id as vendor_id, products.id as product_id, products.image as product_image, products.time as product_time_created, products.time_update as product_time_updated, products.visibility as product_visibility, products.shop_categorie as product_category, products.quantity as product_quantity_available, products.procurement as product_procurement, products.url as product_url, products.virtual_products, products.brand_id as product_brand_id, products.position as product_position , products_translations.title, products_translations.description, products_translations.price, products_translations.old_price, products_translations.basic_description')->get('products');
        return $query->result_array();
    }

    public function getProduct($lang, $id)
    {
        $this->db->join('vendors', 'vendors.id = products.vendor_id', 'left');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', $lang);
        $this->db->where('products.id', $id);
        $this->db->limit(1);
        $query = $this->db->select('vendors.name as vendor_name, vendors.id as vendor_id, products.id as product_id, products.image as product_image, products.time as product_time_created, products.time_update as product_time_updated, products.visibility as product_visibility, products.shop_categorie as product_category, products.quantity as product_quantity_available, products.procurement as product_procurement, products.url as product_url, products.virtual_products, products.brand_id as product_brand_id, products.position as product_position , products_translations.title, products_translations.description, products_translations.price, products_translations.old_price, products_translations.basic_description')->get('products');
        return $query->row_array();
    }

}
