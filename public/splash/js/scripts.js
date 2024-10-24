function show_modal(section)
{
    let modal_title = '';
    let modal_body = '';
    if (section == "vetlexicon") {
        modal_title = "VetLexicon";
        modal_body =
            "<p><strong>Trusted Veterinary Knowledge At Your Fingertips</strong></p><p>Vetlexicon supports the global veterinary community with instant access to the knowledge and experience of 1,100+ leading veterinarians through over 27,000 peer-reviewed articles, images, videos, sounds, and client factsheets.</p>";
    } else if (section == "vtspecialist") {
        modal_title = "VT Specialist";
        modal_body = "<p>We collaborate with veterinary clinics to enable them to extend specialty care to their patients in need. Your practice will maintain management of these cases, with the advantage of active collaboration with our committed board-certified experts. In instances where a transfer to a specialty hospital becomes necessary, our network of specialty hospitals is ready to swiftly secure a place for your patient and streamline the transfer process.</p><p>It's challenging to grant your patients access to specialty care - we're here to simplify it.</p>";
    } else if (section == "colorfulce") {
        modal_title = "ColorfulCE";
        modal_body =
            "<p>As the leading provider of non-clinical skills training, our mission is to help all roles in veterinary practice contribute to the 4 outcomes of successful veterinary practice:</p> \
        <ol>\
        <li>Clinical Resolution</li> \
        <li>Client Satisfaction</li> \
        <li>Financial Resolution</li> \
        <li>Colleague Satisfaction</li> \
        </ol> \
        <p>All our courses are available to access on purchase with no time limit on completion.</p> \
        ";
    } else if (section == "celabs") {
        modal_title = "CE Vet Labs on Demand";
        modal_body =
            "CE Vet Labs on Demand introduces an innovative learning platform featuring renowned veterinarians, <strong>Dr. Jan Bellows</strong> and <strong>Dr. Ira Luskin</strong>. This unique educational resource provides on-demand access to a wealth of knowledge from these acclaimed professionals, ensuring continuous education for veterinarians at any stage of their career. From the latest diagnostic techniques to practical care methods, this platform brings expert insights directly to you. With CE Veterinary Labs on Demand, you have the opportunity to enhance your practice and deliver superior care to your patients. Learn from the best, and enrich your veterinary journey today.";
    }

    $("#modal_title").html(modal_title);
    $("#modal_body").html(modal_body);

    $("#exampleModalCenter").modal('show');
    //$("#exampleModalCenter").modal("show");
}