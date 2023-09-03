using AutoMapper;
using ProducerKafka.Models;

namespace ProducerKafka.ViewModels
{
    public class MappingProfile: Profile
    {
        public MappingProfile()
        {
            CreateMap<MessageKafkaViewModel, MessageKafka>().ForCtorParam(
                "message", 
                opt => opt.MapFrom(src => src.Message)
            ).ForCtorParam(
                "topic", 
                opt => opt.MapFrom(src => new Topic { Name =  src.Topic} )
            );
            
            CreateMap<MessageKafka, MessageKafkaViewModel>()
            .ForMember(dest => dest.Topic, opt => opt.MapFrom(src => src.Topic.Name ));
        }
    }
}