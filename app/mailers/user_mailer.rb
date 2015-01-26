class UserMailer < ActionMailer::Base
  default from: "from@example.com"
  
    def sign_up_notification email 
        @email = email 
        mail to: @email, subject: "You've been signed up at workplace.com!"
    end
end
