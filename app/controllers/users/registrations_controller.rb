class Users::RegistrationsController < Devise::RegistrationsController
    before_filter :configure_sign_up_params, only: [:create]
    before_filter :configure_account_update_params, only: [:update]

  # GET /resource/sign_up
  # def new
  #   super
  # end

  # POST /resource
    def create
        super
        
        organization = Organization.new 
        organization.name = @user.full_name
        organization.save
        organization.users << @user 
        
        #This role will help to find users that created organizations and allow them to edit those organizations
        @user.add_role "created_organization_#{organization.id}"
        
        UserMailer.sign_up_notification(@user.email).deliver
    end

  # GET /resource/edit
  # def edit
  #   super
  # end

  # PUT /resource
  # def update
  #   super
  # end

  # DELETE /resource
  # def destroy
  #   super
  # end

  # GET /resource/cancel
  # Forces the session data which is usually expired after sign
  # in to be expired now. This is useful if the user wants to
  # cancel oauth signing in/up in the middle of the process,
  # removing all OAuth session data.
  # def cancel
  #   super
  # end

  # protected

  # You can put the params you want to permit in the empty array.
    def configure_sign_up_params
        devise_parameter_sanitizer.for(:sign_up) { |u| u.permit(:first_name, :last_name, :email, :password, :password_confirmation) }
    end

  # You can put the params you want to permit in the empty array.
    def configure_account_update_params
        devise_parameter_sanitizer.for(:update) { |u| u.permit(:first_name, :last_name, :email, :password, :password_confirmation) }
    end

  # The path used after sign up.
  # def after_sign_up_path_for(resource)
  #   super(resource)
  # end

  # The path used after sign up for inactive accounts.
  # def after_inactive_sign_up_path_for(resource)
  #   super(resource)
  # end
end
