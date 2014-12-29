class Organization < ActiveRecord::Base
    validates :name, presence: true, length: { in: 6..35, message: "must be 6 to 35 characters long"}, format: { with: /\A[A-z0-9\.\\\/\(\)\?\$\&\s]{6,35}\z/, message: "can only use upper & lower case letters, numbers and these special characters: . \ / ( ) ? $ &" }

    has_and_belongs_to_many :users
    has_many :projects, dependent: :destroy
    
    #Just a method to add an employee. The form won't work without this.
    def add_employee(email)
        employee = User.find_by(email: email)
        
        self.users << employee
    end 

end
