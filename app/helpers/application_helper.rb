module ApplicationHelper

    def header(page_header)
        content_for(:header) { page_header }
    end 

end
