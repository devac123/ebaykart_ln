<?php
namespace Drupal\commerce_rec\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use \Drupal\user\Entity\User;
use \Drupal\node\Entity\Node;
use Drupal\Core\Form\ConfigFormBase; 


class RegisterForm extends ConfigFormBase {
    public function getFormId() {
        return 'Add_user';
      }
    /**  
   * {@inheritdoc}  
   */  
    protected function getEditableConfigNames() {  
      return [  
        'commerce_rec.adminsettings',  
      ];  
    } 
    public function buildForm(array $form, FormStateInterface $form_state) {
        // $config = $this->config('commerce_rec.adminsettings');  
        $roles = \Drupal\user\Entity\Role::loadMultiple();
        $role_option = [];
        foreach ($roles as $role) {
           array_push($role_option,ucfirst($role->id()));
        }
        $form['role'] =[
          '#type' => 'select',
          '#title' => $this->t('Role'),
          '#options' => $role_option, 
        ];
      
        // ************* get variation_type****************
        $variation_type = [];
        $product_variation_types = \Drupal::entityTypeManager()->getStorage('commerce_product_variation_type')->loadMultiple();
        
        foreach ($product_variation_types as $key => $value) {
          array_push($variation_type,ucfirst($key));
        }
      
         $form['Variation'] =[
          '#type' => 'select',
          '#title' => $this->t('Variation'),
          '#options' => $variation_type, 
         ];

        // ************* get variation_type****************

        

        
        $form['submit'] = [
          '#type' => 'submit',
          '#value' => $this->t('Submit')
        ];
          return $form;
    }
    public function validateForm(array &$form, FormStateInterface $form_state) {
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
    }


}