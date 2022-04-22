<?php
namespace Drupal\commerce_rec\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use \Drupal\user\Entity\User;
use \Drupal\node\Entity\Node;
use Drupal\Core\Form\ConfigFormBase; 
use Drupal\commerce_product\Entity\ProductVariationType;


class RoleAssignForm extends ConfigFormBase {
    public function getFormId() {
        return 'assign_role';
      }
    /**  
   * {@inheritdoc}  
   */  
    protected function getEditableConfigNames() {  
      return [  
        'commerce_rec.admin-settings',  
      ];  
    } 
    public function buildForm(array $form, FormStateInterface $form_state) {
      $vaiation_role = '<table>
                            <thead>
                                <th>product variation type</th>
                                <th>Role</th>
                            </thead>
                            variation_type$
                        </table>';
        // load all the variationtype                        
        $product_variation_types = \Drupal::entityTypeManager()->getStorage('commerce_product_variation_type')->loadMultiple();
         $var_type = "";

        foreach ($product_variation_types as $key => $value) {
          $config = \Drupal::config('commerce_rec.admin-settings');
          $role = $config->get($key);
          if($role == null){
            $var_type .= '<tbody><tr><td>'. $key .'</td>'.'<td>'. '-' .'</td>'.'</tr></tbody>';
          }
          else{
            $var_type .= '<tbody><tr><td>'. $key .'</td>'.'<td>'. $role .'</td>'.'</tr></tbody>';
          }
        }
        $Variation_role = str_replace("variation_type$",$var_type,$vaiation_role);

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
        
        foreach ($product_variation_types as $key => $value) {
          array_push($variation_type,ucfirst($key));
        }
         $form['variation_type'] =[
          '#type' => 'select',
          '#title' => $this->t('PRODUCT VARIATION TYPE'),
          '#options' => $variation_type, 
         ];
      
        // ************* get variation_type****************
        $form['submit'] = [
          '#type' => 'submit',
          '#value' => $this->t('Submit')
        ];
         
        $config = \Drupal::config('commerce_rec.admin-settings');
        $roles = $config->get();

          $form['variation_type_role_listing'] =[
            '#markup' => $Variation_role
          ];
          // foreach($roles as $var_type=>$role){
        // }
      
         
         
          return $form;
    }
    public function validateForm(array &$form, FormStateInterface $form_state) {
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
      $key = $form_state->getValue('variation_type');
      $val = $form['variation_type']['#options'][$key];

      $role_key = $form_state->getValue('role');
      $role_value = $form['role']['#options'][$role_key];
      
      parent::submitForm($form, $form_state);
         $this->config('commerce_rec.admin-settings')
        ->set(strtolower($val), $role_value)->save();
        
        $config = \Drupal::config('commerce_rec.admin-settings');
        $role = $config->get();
    }


}
?>