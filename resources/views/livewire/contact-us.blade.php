<div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Contact
                    </h1>
                    <p class="lead">
                        Don't Hesitate to Contact Us.
                    </p>
                </div>
            </div>
        </div>

        <section class="pb-0">
            <div class="contact1 mb-5">
                <div class="container">
                    <div class="row mt-3">
                        <div class="col-lg-7">
                            <div class="contact-wrapper">
                                <h3 class="title font-weight-normal mt-0 text-left">Send Us a Message</h3>
                                    @if(Session::has('message'))
									<div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
									@endif
                                <form data-aos="fade-left" data-aos-duration="1200" wire:submit.prevent="sendMessage">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Full Name" wire:model="name">
                                                @error('name') <p class="text-danger">{{$message}}</p>@enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input class="form-control" type="email" placeholder="Email" wire:model="email">
                                                @error('email') <p class="text-danger">{{$message}}</p>@enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <textarea class="form-control" rows="3" placeholder="Message" wire:model="message"></textarea>
                                                @error('message') <p class="text-danger">{{$message}}</p>@enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-right">
                                            <button type="submit" class="btn btn-lg btn-primary mb-5">Send</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="detail-wrapper p-5 bg-primary">
                                <h3 class="font-weight-normal mb-3 text-light">
                                    Freshcery Headquarter
                                </h3>

                                <p class="text-light">
                                    BP, Tangier<br>
                                    Nouha, professional chef and entrepreneur<br>
                                </p>

                                <p class="text-light">
                                    <i class="fas fa-phone"></i> 0898986362<br>
                                    <i class="fas fa-envelope"></i> hello@freshcery.com
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3238.610201959178!2d-5.897011849859887!3d35.7358039344886!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0b87d71f995045%3A0xc35a87c33b565280!2sFacult%C3%A9%20des%20sciences%20et%20techniques%20de%20Tanger!5e0!3m2!1sfr!2sma!4v1675087075554!5m2!1sfr!2sma" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen></iframe>
        </section>
    </div>