
using Microsoft.AspNetCore.Mvc;
using ProducerKafka.Models;
using AutoMapper;
using ProducerKafka.ViewModels;

namespace ProducerKafka.Controllers
{
    [Route("[controller]")]
    public class ProducerKafkaController : ControllerBase
    {
        private readonly ILogger<ProducerKafkaController> _logger;
        private readonly IMapper _mapper;
        private readonly Producer _producer;

        public ProducerKafkaController(
            ILogger<ProducerKafkaController> logger,
            IMapper mapper
        )
        {
            _logger = logger;
            _mapper = mapper;
            _producer = new Producer();
        }

        [HttpPost(Name = "PostNewMessage")]
        public IActionResult NewMessage([FromBody] MessageKafkaViewModel messageKafkaViewModel)
        {
            try
            {
                var messageKafka = _mapper.Map<MessageKafka>(messageKafkaViewModel);
                var message = _producer.Execute(messageKafka);
                return Ok(message.Result);
            }
            catch (Exception ex)
            {
                _logger.LogError(ex, "Erro in new message", messageKafkaViewModel);
                return Problem(ex.Message, null, 500, "Erro in new message");
            }
        }
    }
}