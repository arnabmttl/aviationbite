@extends('layouts.frontend.app')

@section('title', 'About Us')

@section('content')
    <!-- BEGIN: About Us -->
    <!-- About Us -->
    <section class="about mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="aboutImg">
                        <img src="{{ asset('frontend/images/about-us.png') }}">
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="aboutText">
                        <p class="title">About Us</p>
                        <p class="desc">Lorem Ipsum is simply dummy text of the printing and industry.</p>
                        <p class="text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survive</p>
                        <ul>
                            <li>Proin congue justo a mi malesuada, sed auctor enim ullamcorper.</li>
                            <li>Morbi et nisi egestas, vestibulum purus quis, imperdiet orci.</li>
                            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                            <li>Morbi scelerisque purus sed porta mollis.</li>
                        </ul>
                        <button class="btn btnBlue">Know More</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Key Benefits -->
    <section class="keyBenefits mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="prec-bef-test">
                        <h5>Some Of Our Key Benefits</h5>
                    </div>
                </div>
            </div>
            <div class="row precautionCont">
                <div class="col-lg-4 abt-caution">
                    <div class="icon">
                        <img src="{{ asset('frontend/images/coverage.png') }}">
                    </div>
                    <p class="title">Wide Coverage</p>
                    <p class="desc">Lorem Ipsum is simply dummy text of the printing.</p>
                </div>
                <div class="col-lg-4 abt-caution">
                    <div class="icon">
                        <img src="{{ asset('frontend/images/cloud.png') }}">
                    </div>
                    <p class="title">Cloud</p>
                    <p class="desc">Lorem Ipsum is simply dummy text of the printing.</p>
                </div>
                <div class="col-lg-4 abt-caution">
                    <div class="icon">
                        <img src="{{ asset('frontend/images/lms.png') }}">
                    </div>
                    <p class="title">LMS</p>
                    <p class="desc">Lorem Ipsum is simply dummy text of the printing.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- About Info -->
    <section class="aboutInfo mt-5">
        <div class="container">
            <p class="title">About Us</p>
            <p class="text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam aliquid enim porro rem velit doloremque reprehenderit perspiciatis, modi deserunt fugiat facere expedita. Quia quod debitis ad minus dolor inventore doloremque repudiandae nobis et nulla eaque itaque magni asperiores odio, aliquid laborum natus corporis animi. Iure corporis suscipit, at animi placeat.</p>
        </div>
    </section>
    <!-- About Info -->
    <section class="aboutInfo mt-3 mb-5">
        <div class="container">
            <p class="title">Why do we use it?</p>
            <p class="text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis delectus minus amet explicabo repellendus animi omnis beatae culpa ducimus quisquam rem esse voluptatum quo accusamus doloribus est perspiciatis, distinctio modi. Dolorum a consectetur maiores eaque sint quam enim, asperiores optio necessitatibus quaerat veniam blanditiis, ad exercitationem at! Debitis ipsa porro quam cupiditate qui nisi. Magnam sed enim optio corporis rem praesentium. Animi quos ipsam dolorem, facere dignissimos autem eos veniam voluptatibus commodi blanditiis at cum corporis magni molestias, asperiores culpa iste atque possimus deleniti, obcaecati nostrum nisi accusamus adipisci nobis repellendus! Saepe quas corrupti repudiandae architecto, sequi eveniet, amet quis temporibus corporis eum provident autem, iusto eos culpa rerum id magni, deleniti libero sint voluptatum repellendus a fugit dolorum. Repudiandae nihil velit provident, nesciunt, laudantium voluptates necessitatibus sunt veritatis exercitationem expedita deleniti distinctio labore error. Exercitationem impedit ex nemo officiis laudantium hic eius corporis non consequuntur perferendis dolorum architecto laborum, nulla. Quaerat ipsum provident repellendus nulla ratione illo neque in enim ullam necessitatibus, ut, et veniam soluta quod, at quidem voluptas quia quibusdam tenetur nemo corporis quos tempora sed ea perferendis. Culpa magni, at facere? Voluptatibus ratione sunt molestias explicabo asperiores, repellat voluptates qui enim autem repellendus totam? Nostrum autem cum ipsa atque adipisci ratione et? Non necessitatibus asperiores, quasi rerum placeat sunt libero eaque quia temporibus alias est vel dolor cum officia fuga, laborum quod praesentium sit, cupiditate aut autem illum. Ad, iusto similique? Minus harum quos excepturi similique, quasi et ducimus beatae fugit consequatur culpa modi minima quam iste placeat dolore neque natus, corporis sapiente distinctio aliquam. Obcaecati debitis earum error, iste atque ipsam, facere, eligendi laudantium sint eum dignissimos id!</p>
            <ul>
                <li>Proin congue justo a mi malesuada, sed auctor enim ullamcorper.</li>
                <li>Morbi et nisi egestas, vestibulum purus quis, imperdiet orci.</li>
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                <li>Morbi scelerisque purus sed porta mollis.</li>
            </ul>
        </div>
    </section>
    <!-- END: About Us -->
@endsection