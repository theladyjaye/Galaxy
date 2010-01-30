//
//  Constellation.m
//  Constellation
//
//  Created by Adam Venturella on 1/24/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import "Constellation.h"
#import "GalaxyOptions.h"
#import "GalaxyChannels.h"

#import "CNTopicList.h"
#import "CNMessages.h"

@implementation Constellation
@synthesize delegate;

+ (Constellation *) constellationWithDelegate:(id<ConstellationDelegate>)delegate
{
	Constellation * constellation   = [[Constellation alloc] init];
	constellation.delegate          = delegate;
	return [constellation autorelease];
}

- (void)forums
{
	if(delegate && [delegate constellationShouldGetForums:self])
	{
		[self channels:@selector(didReceiveForums:)];
	}
}


- (void)topics:(NSString *)channel page:(NSUInteger)page limit:(NSUInteger)limit
{
	if(delegate && [delegate constellationShouldGetTopics:self forForum:channel])
	{
		CNTopicList * command    = [[CNTopicList alloc]init];
		command.callback         = @selector(didReceiveTopics:);
		GalaxyOptions  * options = [self.defaultOptions copy];
		options.context          = channel;
		command.content          = [NSDictionary dictionaryWithObjectsAndKeys:[NSString stringWithFormat:@"%u", page], @"page", 
									                                          [NSString stringWithFormat:@"%u", limit], @"limit", nil];
		
		[self execute:command options:options];
		[options release];
		[command release];
	}
}

- (void)messages:(NSString *)topic page:(NSUInteger)page limit:(NSUInteger)limit
{
	if(delegate && [delegate constellationShouldGetMessages:self forTopic:topic])
	{
		CNMessages * command     = [[CNMessages alloc]init];
		command.callback         = @selector(didReceiveMessages:);
		GalaxyOptions  * options = [self.defaultOptions copy];
		options.context          = topic;
		command.content          = [NSDictionary dictionaryWithObjectsAndKeys:[NSString stringWithFormat:@"%u", page], @"page", 
									                                          [NSString stringWithFormat:@"%u", limit], @"limit", nil];
		
		[self execute:command options:options];
		[options release];
		[command release];
	}
}


- (void) didReceiveForums:(NSData *)data
{
	[delegate constellationDidGetForums:data];
}

- (void) didReceiveTopics:(NSData *)data
{
	[delegate constellationDidGetTopics:data];
}

- (void) didReceiveMessages:(NSData *)data
{
	[delegate constellationDidGetMessages:data];
}

@end
