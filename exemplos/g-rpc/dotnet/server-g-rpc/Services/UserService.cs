using System.Runtime.CompilerServices;
using Grpc.Core;
using TesteGrpc.Teste;

namespace serve_g_rpc.Services;

public class UserService : User.UserBase
{
    private readonly ILogger<UserService> _logger;
    private static readonly Random _random = new Random();
    public UserService(ILogger<UserService> logger)
    {
        _logger = logger;
    }

    public override Task<UserReply> NewUser(NewUserRequest request, ServerCallContext context)
    {
        return Task.FromResult(new UserReply
        {
            Message = $"Hello 2 {request.Name} {request.LastName}"
        });
    }
    public override async Task NewUserStream(NewUserRequest request,
                                            IServerStreamWriter<UserReply> responseStream,
                                            ServerCallContext context)
    {
        foreach (var x in Enumerable.Range(1, 10))
        {
            await Task.Delay(5000);
            var result = new UserReply { Message = $"My stream User {x}" };
            Console.WriteLine(result);
            await responseStream.WriteAsync(result);
        }
    }
}
