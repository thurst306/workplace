class Project < ActiveRecord::Base
    validates :name, presence: true
    validates :name, length: { in: 6..35, message: "must be 6 to 35 characters long"}
    validates :name, format: { with: /[A-z0-9\.\\\/\(\)\?\$\&\s]{6,35}/, message: "can only use upper & lower case letters, numbers and these special characters: . \ / ( ) ? $ &" }
    
    has_many :assignments
    has_many :employees, through: :assignments
    has_many :jobs
end
